<?php

namespace App\Http\Middleware;

use App\Services\DiscordAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestoreDiscordRememberedSession
{
    public function __construct(
        protected DiscordAuthService $discordAuthService,
    ) {
    }

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->discordAuthService->restoreRememberedUser($request);

        return $next($request);
    }
}
