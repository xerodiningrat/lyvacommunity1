<?php

namespace App\Http\Middleware;

use App\Services\DiscordAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDiscordCoreMember
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

        if (! ($discordUser['is_core_member'] ?? false)) {
            return redirect()->route('home')->with('toast', 'Dashboard hanya untuk member inti LYVA.');
        }

        return $next($request);
    }
}
