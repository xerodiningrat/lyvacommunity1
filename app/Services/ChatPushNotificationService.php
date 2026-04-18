<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatPushSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Throwable;

class ChatPushNotificationService
{
    public function isConfigured(): bool
    {
        return filled($this->publicKey()) && filled($this->privateKey());
    }

    /**
     * @return array{configured:bool,publicKey:string|null}
     */
    public function bootstrap(): array
    {
        return [
            'configured' => $this->isConfigured(),
            'publicKey' => $this->publicKey(),
        ];
    }

    /**
     * @param  array<string, mixed>  $subscription
     */
    public function subscribe(string $discordUserId, array $subscription, ?string $contentEncoding = null, ?string $userAgent = null): void
    {
        if (! $this->isConfigured() || ! Schema::hasTable('chat_push_subscriptions')) {
            return;
        }

        $endpoint = trim((string) ($subscription['endpoint'] ?? ''));

        if ($endpoint === '') {
            return;
        }

        ChatPushSubscription::query()->updateOrCreate(
            ['endpoint_hash' => $this->endpointHash($endpoint)],
            [
                'discord_user_id' => $discordUserId,
                'endpoint' => $endpoint,
                'public_key' => data_get($subscription, 'keys.p256dh'),
                'auth_token' => data_get($subscription, 'keys.auth'),
                'content_encoding' => $contentEncoding ?: (string) ($subscription['contentEncoding'] ?? ''),
                'user_agent' => filled($userAgent) ? mb_substr($userAgent, 0, 500) : null,
                'last_used_at' => now(),
            ],
        );
    }

    public function unsubscribe(string $discordUserId, string $endpoint): void
    {
        if (! Schema::hasTable('chat_push_subscriptions')) {
            return;
        }

        $endpoint = trim($endpoint);

        if ($endpoint === '') {
            return;
        }

        ChatPushSubscription::query()
            ->where('discord_user_id', $discordUserId)
            ->where('endpoint_hash', $this->endpointHash($endpoint))
            ->delete();
    }

    public function sendNewMessage(ChatMessage $chatMessage): void
    {
        if (! $this->isConfigured() || ! Schema::hasTable('chat_push_subscriptions')) {
            return;
        }

        $subscriptions = ChatPushSubscription::query()
            ->where('discord_user_id', '!=', (string) $chatMessage->discord_user_id)
            ->get();

        if ($subscriptions->isEmpty()) {
            return;
        }

        try {
            $webPush = new WebPush([
                'VAPID' => [
                    'subject' => $this->subject(),
                    'publicKey' => $this->publicKey(),
                    'privateKey' => $this->privateKey(),
                ],
            ], [
                'TTL' => 300,
                'urgency' => 'high',
            ]);

            $payload = $this->payloadFor($chatMessage);

            foreach ($subscriptions as $subscription) {
                $webPush->queueNotification(
                    Subscription::create([
                        'endpoint' => $subscription->endpoint,
                        'keys' => [
                            'p256dh' => $subscription->public_key,
                            'auth' => $subscription->auth_token,
                        ],
                        'contentEncoding' => $subscription->content_encoding ?: Subscription::defaultContentEncoding->value,
                    ]),
                    $payload,
                );
            }

            foreach ($webPush->flush() as $report) {
                $endpointHash = $this->endpointHash($report->getRequest()->getUri()->__toString());

                if ($report->isSubscriptionExpired()) {
                    ChatPushSubscription::query()
                        ->where('endpoint_hash', $endpointHash)
                        ->delete();

                    continue;
                }

                if ($report->isSuccess()) {
                    ChatPushSubscription::query()
                        ->where('endpoint_hash', $endpointHash)
                        ->update(['last_used_at' => now()]);
                }
            }
        } catch (Throwable $throwable) {
            Log::warning('Web push chat notification gagal dikirim.', [
                'message_id' => $chatMessage->id,
                'error' => $throwable->getMessage(),
            ]);
        }
    }

    protected function payloadFor(ChatMessage $chatMessage): string
    {
        return json_encode([
            'title' => $chatMessage->display_name ?: 'Pesan Baru',
            'body' => mb_strimwidth((string) $chatMessage->message, 0, 120, '...'),
            'icon' => '/pwa-192.png',
            'badge' => '/favicon-32.png',
            'tag' => 'chat-message-'.$chatMessage->id,
            'url' => '/chat',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{"title":"Pesan Baru","url":"/chat"}';
    }

    protected function subject(): string
    {
        return (string) (config('services.webpush.subject') ?: config('app.url') ?: 'http://localhost');
    }

    protected function publicKey(): ?string
    {
        $value = trim((string) config('services.webpush.public_key', ''));

        return $value !== '' ? $value : null;
    }

    protected function privateKey(): ?string
    {
        $value = trim((string) config('services.webpush.private_key', ''));

        return $value !== '' ? $value : null;
    }

    protected function endpointHash(string $endpoint): string
    {
        return hash('sha256', $endpoint);
    }
}
