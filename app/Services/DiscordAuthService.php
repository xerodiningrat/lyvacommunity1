<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class DiscordAuthService
{
    public const SESSION_KEY = 'discord_auth';
    public const REMEMBER_COOKIE = 'lyva_discord_remember';
    public const REMEMBER_MINUTES = 43200;

    public function redirectUrl(): string
    {
        $configuredRedirect = trim((string) config('services.discord.redirect_uri', ''));

        if ($configuredRedirect !== '') {
            return $configuredRedirect;
        }

        return route('auth.discord.callback');
    }

    public function isConfigured(): bool
    {
        return filled(config('services.discord.client_id'))
            && filled(config('services.discord.client_secret'))
            && filled(config('services.discord.bot_token'))
            && filled(config('services.discord.invite_url'));
    }

    public function authorizationUrl(): string
    {
        $state = Str::random(40);

        session(['discord_oauth_state' => $state]);

        return 'https://discord.com/oauth2/authorize?'.http_build_query([
            'client_id' => (string) config('services.discord.client_id'),
            'redirect_uri' => $this->redirectUrl(),
            'response_type' => 'code',
            'scope' => 'identify',
            'prompt' => 'consent',
            'state' => $state,
        ]);
    }

    /**
     * @return array{
     *     id: string,
     *     name: string,
     *     username: string,
     *     avatar_url: string|null,
     *     is_core_member: bool,
     *     primary_role: string|null,
     *     redirect_to: string
     * }
     */
    public function authenticate(string $code, ?string $state): array
    {
        $expectedState = (string) session()->pull('discord_oauth_state', '');

        if ($state === null || $state === '' || ! hash_equals($expectedState, $state)) {
            throw new RuntimeException('State login Discord tidak valid.');
        }

        $tokenResponse = Http::asForm()
            ->acceptJson()
            ->connectTimeout(5)
            ->timeout(15)
            ->post('https://discord.com/api/oauth2/token', [
                'grant_type' => 'authorization_code',
                'client_id' => (string) config('services.discord.client_id'),
                'client_secret' => (string) config('services.discord.client_secret'),
                'redirect_uri' => $this->redirectUrl(),
                'code' => $code,
            ]);

        if (! $tokenResponse->successful()) {
            throw new RuntimeException('Gagal mengambil access token Discord.');
        }

        $accessToken = (string) data_get($tokenResponse->json(), 'access_token', '');

        if ($accessToken === '') {
            throw new RuntimeException('Access token Discord kosong.');
        }

        $userResponse = Http::acceptJson()
            ->withToken($accessToken)
            ->connectTimeout(5)
            ->timeout(15)
            ->get('https://discord.com/api/v10/users/@me');

        if (! $userResponse->successful()) {
            throw new RuntimeException('Gagal mengambil profil user Discord.');
        }

        $user = $userResponse->json();
        $userId = (string) data_get($user, 'id', '');

        if ($userId === '') {
            throw new RuntimeException('ID user Discord tidak ditemukan.');
        }

        $guildMember = $this->fetchGuildMember($userId);
        $leadershipRoles = collect(config('services.discord.leadership_roles', []))->keyBy('id');
        $userRoleIds = collect(data_get($guildMember, 'roles', []))
            ->map(fn (mixed $roleId): string => (string) $roleId)
            ->filter();

        $primaryRole = $userRoleIds
            ->map(fn (string $roleId): ?array => $leadershipRoles->get($roleId))
            ->filter()
            ->sortBy('priority')
            ->first();

        $payload = [
            'id' => $userId,
            'name' => (string) (data_get($user, 'global_name') ?: data_get($user, 'username', 'Discord User')),
            'username' => (string) data_get($user, 'username', 'discord-user'),
            'avatar_url' => $this->avatarUrl($user),
            'is_core_member' => $primaryRole !== null,
            'primary_role' => $primaryRole['label'] ?? null,
            'redirect_to' => route('home'),
        ];

        session([self::SESSION_KEY => $payload]);

        return $payload;
    }

    public function currentUser(): ?array
    {
        $user = session(self::SESSION_KEY);

        return is_array($user) ? $user : null;
    }

    public function currentUserFromRequest(Request $request): ?array
    {
        $sessionUser = $request->session()->get(self::SESSION_KEY);

        if (is_array($sessionUser)) {
            return $sessionUser;
        }

        return $this->restoreRememberedUser($request);
    }

    public function restoreRememberedUser(Request $request): ?array
    {
        $sessionUser = $request->session()->get(self::SESSION_KEY);

        if (is_array($sessionUser)) {
            return $sessionUser;
        }

        $remembered = $request->cookie(self::REMEMBER_COOKIE);

        if (! is_string($remembered) || $remembered === '') {
            return null;
        }

        $payload = json_decode(urldecode($remembered), true);

        if (! is_array($payload) || ! $this->isValidPayload($payload)) {
            return null;
        }

        $request->session()->put(self::SESSION_KEY, $payload);

        return $payload;
    }

    public function queueRememberCookie(array $payload): void
    {
        cookie()->queue(
            cookie(
                self::REMEMBER_COOKIE,
                json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                self::REMEMBER_MINUTES,
                '/',
                config('session.domain'),
                (bool) config('session.secure'),
                true,
                false,
                (string) config('session.same_site', 'lax'),
            ),
        );
    }

    public function clearRememberCookie(): void
    {
        cookie()->queue(cookie()->forget(
            self::REMEMBER_COOKIE,
            '/',
            config('session.domain'),
        ));
    }

    public function logout(): void
    {
        session()->forget([
            self::SESSION_KEY,
            'discord_oauth_state',
        ]);

        $this->clearRememberCookie();
    }

    protected function fetchGuildMember(string $userId): ?array
    {
        $guildId = $this->guildId();
        $botToken = (string) config('services.discord.bot_token', '');

        if ($guildId === null || $botToken === '') {
            return null;
        }

        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => "Bot {$botToken}",
            ])
            ->connectTimeout(5)
            ->timeout(15)
            ->get("https://discord.com/api/v10/guilds/{$guildId}/members/{$userId}");

        if (! $response->successful()) {
            return null;
        }

        $member = $response->json();

        return is_array($member) ? $member : null;
    }

    protected function guildId(): ?string
    {
        $inviteUrl = (string) config('services.discord.invite_url', '');
        $inviteCode = trim((string) str($inviteUrl)->afterLast('/'));

        if ($inviteCode === '') {
            return null;
        }

        $response = Http::acceptJson()
            ->connectTimeout(5)
            ->timeout(10)
            ->get("https://discord.com/api/v10/invites/{$inviteCode}", [
                'with_counts' => 'true',
            ]);

        if (! $response->successful()) {
            return null;
        }

        $guildId = data_get($response->json(), 'guild.id');

        return is_string($guildId) && $guildId !== '' ? $guildId : null;
    }

    /**
     * @param  array<string, mixed>  $user
     */
    protected function avatarUrl(array $user): ?string
    {
        $userId = (string) data_get($user, 'id', '');
        $avatar = (string) data_get($user, 'avatar', '');

        if ($userId === '' || $avatar === '') {
            return null;
        }

        return sprintf(
            'https://cdn.discordapp.com/avatars/%s/%s.%s?size=128',
            $userId,
            $avatar,
            str_starts_with($avatar, 'a_') ? 'gif' : 'png',
        );
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    protected function isValidPayload(array $payload): bool
    {
        return filled($payload['id'] ?? null)
            && filled($payload['name'] ?? null)
            && filled($payload['username'] ?? null)
            && array_key_exists('is_core_member', $payload)
            && filled($payload['redirect_to'] ?? null);
    }
}
