<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DiscordLeadershipDirectory
{
    /**
     * @return array<int, array{
     *     name: string,
     *     role: string,
     *     badge_class: string,
     *     icon: string,
     *     meta: string,
     *     avatar_text: string,
     *     avatar_url: string|null
     * }>
     */
    public function get(): array
    {
        $inviteUrl = (string) config('services.discord.invite_url', '');
        $token = (string) config('services.discord.bot_token', '');

        if ($inviteUrl === '' || $token === '') {
            return [];
        }

        return Cache::remember(
            'discord.leadership.directory.v4',
            now()->addSeconds((int) config('services.discord.cache_ttl_seconds', 300)),
            fn (): array => $this->fetch($inviteUrl, $token),
        );
    }

    /**
     * @return array<int, array{
     *     name: string,
     *     role: string,
     *     badge_class: string,
     *     icon: string,
     *     meta: string,
     *     avatar_text: string,
     *     avatar_url: string|null
     * }>
     */
    protected function fetch(string $inviteUrl, string $token): array
    {
        $leadershipRoles = collect(config('services.discord.leadership_roles', []))
            ->keyBy('id');
        $hiddenUserIds = collect(config('services.discord.leadership_hidden_user_ids', []))
            ->filter()
            ->map(fn (mixed $userId): string => (string) $userId)
            ->values();

        if ($leadershipRoles->isEmpty()) {
            return [];
        }

        try {
            $guildId = $this->fetchGuildId($inviteUrl);

            if ($guildId === null) {
                return [];
            }

            $roles = $this->fetchRoles($token, $guildId);
            $roleCounts = $this->fetchRoleCounts($token, $guildId);
            $members = $this->fetchMembers($token, $guildId);

            if ($members !== null) {
                $memberCards = $this->mapMembersToCards($members, $leadershipRoles, $guildId, $hiddenUserIds);

                if ($memberCards->isNotEmpty()) {
                    return $memberCards->all();
                }
            }

            return $this->mapRoleSummariesToCards($roles, $roleCounts, $leadershipRoles)->all();
        } catch (Throwable $exception) {
            Log::warning('Failed to build Discord leadership directory.', [
                'message' => $exception->getMessage(),
            ]);

            return [];
        }
    }

    protected function fetchGuildId(string $inviteUrl): ?string
    {
        $inviteCode = str($inviteUrl)->afterLast('/')->trim()->value();

        if ($inviteCode === '') {
            return null;
        }

        $response = Http::baseUrl('https://discord.com/api/v10')
            ->acceptJson()
            ->connectTimeout(5)
            ->timeout(10)
            ->retry([200, 500], throw: false)
            ->get("/invites/{$inviteCode}", [
                'with_counts' => 'true',
            ]);

        if (! $response->successful()) {
            return null;
        }

        $guildId = data_get($response->json(), 'guild.id');

        return is_string($guildId) && $guildId !== '' ? $guildId : null;
    }

    /**
     * @return Collection<string, array<string, mixed>>
     */
    protected function fetchRoles(string $token, string $guildId): Collection
    {
        $response = Http::baseUrl('https://discord.com/api/v10')
            ->acceptJson()
            ->withHeaders([
                'Authorization' => "Bot {$token}",
            ])
            ->connectTimeout(5)
            ->timeout(10)
            ->retry([200, 500], throw: false)
            ->get("/guilds/{$guildId}/roles");

        if (! $response->successful()) {
            return collect();
        }

        return collect($response->json())
            ->filter(fn (mixed $role): bool => is_array($role))
            ->mapWithKeys(fn (array $role): array => [(string) data_get($role, 'id') => $role]);
    }

    /**
     * @return array<string, int>
     */
    protected function fetchRoleCounts(string $token, string $guildId): array
    {
        $response = Http::baseUrl('https://discord.com/api/v10')
            ->acceptJson()
            ->withHeaders([
                'Authorization' => "Bot {$token}",
            ])
            ->connectTimeout(5)
            ->timeout(10)
            ->retry([200, 500], throw: false)
            ->get("/guilds/{$guildId}/roles/member-counts");

        if (! $response->successful()) {
            return [];
        }

        return collect($response->json())
            ->mapWithKeys(fn (mixed $count, mixed $roleId): array => [
                (string) $roleId => is_numeric($count) ? (int) $count : 0,
            ])
            ->all();
    }

    /**
     * @return Collection<int, array<string, mixed>>|null
     */
    protected function fetchMembers(string $token, string $guildId): ?Collection
    {
        $members = collect();
        $after = '0';

        do {
            $response = Http::baseUrl('https://discord.com/api/v10')
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => "Bot {$token}",
                ])
                ->connectTimeout(5)
                ->timeout(10)
                ->retry([200, 500], throw: false)
                ->get("/guilds/{$guildId}/members", [
                    'limit' => 1000,
                    'after' => $after,
                ]);

            if ($response->status() === 403) {
                return $this->searchMembers($token, $guildId);
            }

            if (! $response->successful()) {
                return null;
            }

            $batch = collect($response->json())
                ->filter(fn (mixed $member): bool => is_array($member))
                ->values();

            if ($batch->isEmpty()) {
                break;
            }

            $members = $members->concat($batch);
            $after = (string) data_get($batch->last(), 'user.id', '0');
        } while ($batch->count() === 1000);

        return $members;
    }

    /**
     * @return Collection<int, array<string, mixed>>|null
     */
    protected function searchMembers(string $token, string $guildId): ?Collection
    {
        $queries = collect(array_merge(range('a', 'z'), range('0', '9')));
        $members = collect();

        foreach ($queries as $query) {
            $response = Http::baseUrl('https://discord.com/api/v10')
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => "Bot {$token}",
                ])
                ->connectTimeout(5)
                ->timeout(10)
                ->retry([200, 500], throw: false)
                ->get("/guilds/{$guildId}/members/search", [
                    'query' => $query,
                    'limit' => 100,
                ]);

            if (! $response->successful()) {
                continue;
            }

            $members = $members->concat(
                collect($response->json())
                    ->filter(fn (mixed $member): bool => is_array($member))
                    ->values(),
            );
        }

        return $members
            ->unique(fn (array $member): string => (string) data_get($member, 'user.id'))
            ->values();
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $members
     * @param  Collection<string, array<string, mixed>>  $leadershipRoles
     * @param  Collection<int, string>  $hiddenUserIds
     * @return Collection<int, array{
     *     name: string,
     *     role: string,
     *     badge_class: string,
     *     icon: string,
     *     meta: string,
     *     avatar_text: string,
     *     avatar_url: string|null
     * }>
     */
    protected function mapMembersToCards(Collection $members, Collection $leadershipRoles, string $guildId, Collection $hiddenUserIds): Collection
    {
        return $members
            ->filter(function (array $member) use ($leadershipRoles, $hiddenUserIds): bool {
                if ((bool) data_get($member, 'user.bot', false)) {
                    return false;
                }

                if ($hiddenUserIds->contains((string) data_get($member, 'user.id', ''))) {
                    return false;
                }

                return collect(data_get($member, 'roles', []))
                    ->contains(fn (mixed $roleId): bool => $leadershipRoles->has((string) $roleId));
            })
            ->map(function (array $member) use ($leadershipRoles, $guildId): ?array {
                $primaryRole = collect(data_get($member, 'roles', []))
                    ->map(fn (mixed $roleId): ?array => $leadershipRoles->get((string) $roleId))
                    ->filter()
                    ->sortBy('priority')
                    ->first();

                if ($primaryRole === null) {
                    return null;
                }

                $displayName = (string) (
                    data_get($member, 'nick')
                    ?? data_get($member, 'user.global_name')
                    ?? data_get($member, 'user.username')
                    ?? 'LYVA Team'
                );

                return [
                    'name' => $displayName,
                    'role' => (string) data_get($primaryRole, 'group', 'Staff'),
                    'badge_class' => (string) data_get($primaryRole, 'badge_class', 'rm'),
                    'icon' => (string) data_get($primaryRole, 'icon', '👥'),
                    'meta' => (string) data_get($primaryRole, 'label', 'Staff'),
                    'avatar_text' => $this->avatarText($displayName),
                    'avatar_url' => $this->avatarUrl($member, $guildId),
                    'priority' => (int) data_get($primaryRole, 'priority', 999),
                ];
            })
            ->filter()
            ->sortBy(fn (array $card): string => str_pad((string) $card['priority'], 3, '0', STR_PAD_LEFT).'-'.$card['name'])
            ->values()
            ->map(function (array $card): array {
                unset($card['priority']);

                return $card;
            });
    }

    /**
     * @param  Collection<string, array<string, mixed>>  $roles
     * @param  array<string, int>  $roleCounts
     * @param  Collection<string, array<string, mixed>>  $leadershipRoles
     * @return Collection<int, array{
     *     name: string,
     *     role: string,
     *     badge_class: string,
     *     icon: string,
     *     meta: string,
     *     avatar_text: string,
     *     avatar_url: string|null
     * }>
     */
    protected function mapRoleSummariesToCards(Collection $roles, array $roleCounts, Collection $leadershipRoles): Collection
    {
        return $leadershipRoles
            ->sortBy('priority')
            ->map(function (array $configuredRole, string $roleId) use ($roles, $roleCounts): array {
                $discordRole = $roles->get($roleId, []);
                $roleLabel = (string) data_get($configuredRole, 'label', 'Staff');
                $memberCount = $roleCounts[$roleId] ?? 0;

                return [
                    'name' => $roleLabel,
                    'role' => (string) data_get($configuredRole, 'group', 'Staff'),
                    'badge_class' => (string) data_get($configuredRole, 'badge_class', 'rm'),
                    'icon' => (string) data_get($configuredRole, 'icon', '👥'),
                    'meta' => $memberCount.' akun',
                    'avatar_text' => $this->avatarText((string) data_get($discordRole, 'name', $roleLabel)),
                    'avatar_url' => null,
                ];
            })
            ->filter(fn (array $card): bool => $card['meta'] !== '0 akun')
            ->values();
    }

    /**
     * @param  array<string, mixed>  $member
     */
    protected function avatarUrl(array $member, string $guildId): ?string
    {
        $userId = (string) data_get($member, 'user.id', '');
        $memberAvatar = (string) data_get($member, 'avatar', '');
        $userAvatar = (string) data_get($member, 'user.avatar', '');

        if ($userId === '') {
            return null;
        }

        if ($memberAvatar !== '') {
            return sprintf(
                'https://cdn.discordapp.com/guilds/%s/users/%s/avatars/%s.%s?size=128',
                $guildId,
                $userId,
                $memberAvatar,
                str_starts_with($memberAvatar, 'a_') ? 'gif' : 'png',
            );
        }

        if ($userAvatar === '') {
            return null;
        }

        return sprintf(
            'https://cdn.discordapp.com/avatars/%s/%s.%s?size=128',
            $userId,
            $userAvatar,
            str_starts_with($userAvatar, 'a_') ? 'gif' : 'png',
        );
    }

    protected function avatarText(string $value): string
    {
        $cleaned = trim(preg_replace('/[^A-Za-z0-9 ]/', ' ', $value) ?? '');

        if ($cleaned === '') {
            return 'LY';
        }

        return (string) collect(preg_split('/\s+/', $cleaned) ?: [])
            ->filter()
            ->take(2)
            ->map(fn (string $segment): string => strtoupper(substr($segment, 0, 1)))
            ->implode('');
    }
}
