<?php

namespace App\Http\Middleware;

use App\Services\DiscordAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDiscordAuthenticated
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $discordUser = $request->session()->get(DiscordAuthService::SESSION_KEY);

        if (! is_array($discordUser)) {
            return redirect()->route('auth.discord.redirect');
        }

        return $next($request);
    }
}
