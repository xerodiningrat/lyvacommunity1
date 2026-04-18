<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatMessageRequest;
use App\Models\ChatMessage;
use App\Models\ChatPresence;
use App\Services\DiscordAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatMessageController extends Controller
{
    public function index(Request $request): View
    {
        $discordUser = $this->currentUser($request);
        $this->ensureTablesReady();
        $this->ensureSeedMessages();
        $this->syncPresence($discordUser);

        return view('chat', [
            'chatBootstrap' => [
                'currentUser' => $discordUser,
                'messages' => $this->messages(),
                'onlineUsers' => $this->onlineUsers($discordUser['id']),
            ],
        ]);
    }

    public function store(StoreChatMessageRequest $request): JsonResponse|RedirectResponse
    {
        $discordUser = $this->currentUser($request);

        if (! Schema::hasTable('chat_messages')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Tabel chat belum siap. Jalankan migrate terlebih dahulu.',
                ], 503);
            }

            return to_route('chat')->with('toast', 'Tabel chat belum siap. Jalankan migrate terlebih dahulu.');
        }

        $chatMessage = ChatMessage::query()->create([
            'message_type' => 'message',
            'discord_user_id' => $discordUser['id'],
            'display_name' => $discordUser['name'],
            'username' => $discordUser['username'],
            'avatar_url' => $discordUser['avatar_url'],
            'avatar_emoji' => $discordUser['avatar'],
            'color_class' => $discordUser['color'],
            'role_key' => $discordUser['role'],
            'message' => $request->validated('message'),
            'reactions' => [],
            'reply_name' => $request->validated('reply_name'),
            'reply_text' => $request->validated('reply_text'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => $this->messages()
                    ->firstWhere('id', $chatMessage->id),
            ]);
        }

        return to_route('chat')->with('status', 'Pesan berhasil dikirim.');
    }

    public function state(Request $request): JsonResponse
    {
        $discordUser = $this->currentUser($request);
        $this->ensureTablesReady();
        $this->ensureSeedMessages();
        $this->syncPresence($discordUser);

        return response()->json([
            'currentUser' => $discordUser,
            'messages' => $this->messages(),
            'onlineUsers' => $this->onlineUsers($discordUser['id']),
        ]);
    }

    public function react(Request $request, ChatMessage $chatMessage): JsonResponse
    {
        $discordUser = $this->currentUser($request);
        $emoji = trim((string) $request->input('emoji', ''));

        abort_if($emoji === '' || mb_strlen($emoji) > 8, 422);

        $reactions = collect($chatMessage->reactions ?? []);
        $users = collect($reactions->get($emoji, []))
            ->map(fn (mixed $id): string => (string) $id)
            ->filter()
            ->values();

        if ($users->contains($discordUser['id'])) {
            $users = $users->reject(fn (string $id): bool => $id === $discordUser['id'])->values();
        } else {
            $users = $users->push($discordUser['id'])->unique()->values();
        }

        if ($users->isEmpty()) {
            $reactions->forget($emoji);
        } else {
            $reactions->put($emoji, $users->all());
        }

        $chatMessage->update([
            'reactions' => $reactions->all(),
        ]);

        return response()->json([
            'ok' => true,
            'reactions' => $chatMessage->fresh()->reactions ?? [],
        ]);
    }

    public function destroy(Request $request, ChatMessage $chatMessage): JsonResponse
    {
        $discordUser = $this->currentUser($request);

        abort_unless($chatMessage->discord_user_id === $discordUser['id'], 403);

        $chatMessage->delete();

        return response()->json(['ok' => true]);
    }

    protected function messages(): Collection
    {
        if (! Schema::hasTable('chat_messages')) {
            return collect();
        }

        return ChatMessage::query()
            ->latest()
            ->take(80)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (ChatMessage $message): array => [
                'id' => $message->id,
                'type' => $message->message_type,
                'uid' => $message->discord_user_id,
                'name' => $message->display_name,
                'avatar' => $message->avatar_emoji ?: $this->avatarEmoji($message->display_name, $message->role_key),
                'color' => $message->color_class ?: $this->colorClass((string) $message->discord_user_id),
                'role' => $message->role_key,
                'text' => $message->message,
                't' => $message->created_at?->valueOf() ?? now()->valueOf(),
                'reacts' => $message->reactions ?? [],
                'reply' => filled($message->reply_name) && filled($message->reply_text)
                    ? ['name' => $message->reply_name, 'text' => $message->reply_text]
                    : null,
            ]);
    }

    /**
     * @return array{id:string,name:string,username:string,avatar_url:?string,is_core_member:bool,primary_role:?string,redirect_to:string,avatar:string,color:string,role:?string}
     */
    protected function currentUser(Request $request): array
    {
        /** @var array{id:string,name:string,username:string,avatar_url:?string,is_core_member:bool,primary_role:?string,redirect_to:string} $discordUser */
        $discordUser = $request->session()->get(DiscordAuthService::SESSION_KEY);

        $role = $this->roleKey($discordUser['primary_role'] ?? null, (bool) ($discordUser['is_core_member'] ?? false));

        return [
            ...$discordUser,
            'avatar' => $this->avatarEmoji($discordUser['name'], $role),
            'color' => $this->colorClass($discordUser['id']),
            'role' => $role,
        ];
    }

    protected function ensureTablesReady(): void
    {
        if (! Schema::hasTable('chat_messages') || ! Schema::hasTable('chat_presences')) {
            return;
        }
    }

    protected function ensureSeedMessages(): void
    {
        // Dummy seed chat has been removed; keep the room empty until real members send messages.
    }

    protected function syncPresence(array $discordUser): void
    {
        if (! Schema::hasTable('chat_presences')) {
            return;
        }

        ChatPresence::query()->updateOrCreate(
            ['discord_user_id' => $discordUser['id']],
            [
                'display_name' => $discordUser['name'],
                'username' => $discordUser['username'],
                'avatar_url' => $discordUser['avatar_url'],
                'avatar_emoji' => $discordUser['avatar'],
                'color_class' => $discordUser['color'],
                'role_key' => $discordUser['role'],
                'last_seen_at' => now(),
            ],
        );
    }

    protected function onlineUsers(string $currentUserId): Collection
    {
        if (! Schema::hasTable('chat_presences')) {
            return collect();
        }

        return ChatPresence::query()
            ->where('last_seen_at', '>=', Carbon::now()->subSeconds(35))
            ->orderByRaw('CASE WHEN discord_user_id = ? THEN 0 ELSE 1 END', [$currentUserId])
            ->orderBy('display_name')
            ->get()
            ->map(fn (ChatPresence $presence): array => [
                'id' => $presence->discord_user_id,
                'name' => $presence->display_name,
                'avatar' => $presence->avatar_emoji ?: $this->avatarEmoji($presence->display_name, $presence->role_key),
                'color' => $presence->color_class ?: $this->colorClass($presence->discord_user_id),
                'role' => $presence->role_key,
            ]);
    }

    protected function roleKey(?string $primaryRole, bool $isCoreMember): ?string
    {
        $role = Str::lower((string) $primaryRole);

        return match (true) {
            str_contains($role, 'founder'), str_contains($role, 'owner') => 'owner',
            str_contains($role, 'admin'), str_contains($role, 'manager') => 'admin',
            str_contains($role, 'moderator'), str_contains($role, 'leader'), str_contains($role, 'team') => 'mod',
            $isCoreMember => 'pro',
            default => null,
        };
    }

    protected function avatarEmoji(string $name, ?string $roleKey): string
    {
        if ($roleKey === 'owner') {
            return '👑';
        }

        if ($roleKey === 'admin') {
            return '🌸';
        }

        if ($roleKey === 'mod') {
            return '🛡️';
        }

        $choices = ['🎮', '⚡', '🐉', '🦊', '🌙', '🌺', '🎯', '🔥', '💎', '🚀'];

        return $choices[abs(crc32($name)) % count($choices)];
    }

    protected function colorClass(string $seed): string
    {
        $choices = ['c-gold', 'c-pink', 'c-teal', 'c-purple', 'c-orange', 'c-green'];

        return $choices[abs(crc32($seed)) % count($choices)];
    }
}
