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

## Laravel Cloud Tanpa Database Cluster

Project ini bisa dijalankan di Laravel Cloud tanpa bayar MySQL cluster dengan memakai SQLite yang disimpan di repo pada `database/database.sqlite`.

Set environment Laravel Cloud seperti ini:

- `APP_KEY`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.laravel.cloud`
- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=file`
- `CACHE_STORE=file`
- `QUEUE_CONNECTION=sync`
- `DISCORD_INVITE_URL`
- `DISCORD_BOT_TOKEN`
- `DISCORD_GALLERY_CHANNEL_ID`
- `DISCORD_GALLERY_LIMIT`
- `DISCORD_CACHE_TTL_SECONDS`

Deploy Commands Laravel Cloud:

```bash
php artisan migrate --force
```

Catatan:

- SQLite file bawaan repo bisa dipakai untuk data awal tanpa cluster database.
- Repo ini tetap punya migration `sessions`, jadi kalau nanti pindah ke MySQL/driver database lagi, session tidak bikin `500`.
- Home dan gallery sudah dibuat fallback-safe, jadi kalau sync Discord gagal, halaman publik tetap bisa render.
