<?php

namespace App\Http\Controllers;

use App\Services\DiscordAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class DiscordAuthController extends Controller
{
    public function redirect(DiscordAuthService $discordAuthService): RedirectResponse
    {
        if (! $discordAuthService->isConfigured()) {
            return to_route('home')->with('toast', 'Login Discord belum dikonfigurasi.');
        }

        return redirect()->away($discordAuthService->authorizationUrl());
    }

    public function callback(Request $request, DiscordAuthService $discordAuthService): RedirectResponse
    {
        $code = (string) $request->query('code', '');

        if ($code === '') {
            return to_route('home')->with('toast', 'Login Discord dibatalkan.');
        }

        try {
            $discordUser = $discordAuthService->authenticate(
                $code,
                $request->query('state'),
            );

            return redirect()->to($discordUser['redirect_to'])->with(
                'toast',
                $discordUser['is_core_member']
                    ? 'Login berhasil. Selamat datang di dashboard, '.$discordUser['name'].'!'
                    : 'Login berhasil, tapi akun Discord kamu belum termasuk member inti.',
            );
        } catch (Throwable $exception) {
            report($exception);

            return to_route('home')->with('toast', 'Login Discord gagal. Coba lagi sebentar.');
        }
    }

    public function logout(DiscordAuthService $discordAuthService): RedirectResponse
    {
        $discordAuthService->logout();

        return to_route('home')->with('toast', 'Kamu sudah logout.');
    }
}
