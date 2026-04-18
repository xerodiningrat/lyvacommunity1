# LYVA Community

Laravel app untuk website komunitas LYVA dengan halaman home, dashboard, gallery, shop, members, events, dan leaderboard.

## Local

1. Copy `.env.example` ke `.env`
2. Isi koneksi database MySQL
3. Jalankan:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

## Laravel Cloud

Agar deploy pertama tidak error, pastikan environment Laravel Cloud kamu punya:

- `APP_KEY`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.laravel.cloud`
- `DB_CONNECTION=mysql`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`
- `DISCORD_INVITE_URL`
- `DISCORD_BOT_TOKEN`
- `DISCORD_GALLERY_CHANNEL_ID`
- `DISCORD_GALLERY_LIMIT`
- `DISCORD_CACHE_TTL_SECONDS`

Deploy Commands Laravel Cloud yang disarankan:

```bash
php artisan migrate --force
```

Catatan:

- Repo ini sekarang sudah punya migration `sessions`, jadi session database tidak lagi bikin `500` saat deploy baru.
- Home dan gallery sudah dibuat fallback-safe, jadi kalau sync Discord gagal atau tabel gallery belum siap, halaman publik tetap bisa render.
- Kalau halaman seperti dashboard, shop, events, atau leaderboard masih error setelah deploy, cek dulu apakah migrasi database benar-benar sudah jalan.
