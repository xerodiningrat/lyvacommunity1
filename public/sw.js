const CACHE_VERSION = 'lyva-pwa-v3';
const APP_SHELL_CACHE = `${CACHE_VERSION}-shell`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;
const APP_SHELL_ASSETS = [
  '/',
  '/gallery',
  '/shop',
  '/members',
  '/events',
  '/leaderboard',
  '/offline.html',
  '/manifest.webmanifest',
  '/lyva-navbar-logo.png',
  '/pwa-192.png',
  '/pwa-512.png',
  '/apple-touch-icon-180.png',
  '/favicon-32.png',
];
const EXCLUDED_PREFIXES = [
  '/login',
  '/logout',
  '/auth/discord',
  '/chat/state',
  '/chat/messages',
  '/dashboard',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(APP_SHELL_CACHE).then((cache) => cache.addAll(APP_SHELL_ASSETS)).then(() => self.skipWaiting()),
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => !key.startsWith(CACHE_VERSION))
          .map((key) => caches.delete(key)),
      ),
    ).then(() => self.clients.claim()),
  );
});

self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  if (request.method !== 'GET' || url.origin !== self.location.origin) {
    return;
  }

  if (EXCLUDED_PREFIXES.some((prefix) => url.pathname.startsWith(prefix))) {
    return;
  }

  if (request.mode === 'navigate') {
    event.respondWith(networkFirst(request));
    return;
  }

  event.respondWith(cacheFirst(request));
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  const targetUrl = event.notification?.data?.url || '/chat';

  event.waitUntil((async () => {
    const allClients = await self.clients.matchAll({
      type: 'window',
      includeUncontrolled: true,
    });

    const existingClient = allClients.find((client) => client.url.includes(targetUrl));

    if (existingClient) {
      await existingClient.focus();
      return;
    }

    await self.clients.openWindow(targetUrl);
  })());
});

self.addEventListener('push', (event) => {
  if (!event.data) {
    return;
  }

  let payload = {};

  try {
    payload = event.data.json();
  } catch (error) {
    payload = {
      title: 'LYVA Community',
      body: event.data.text(),
    };
  }

  event.waitUntil(
    self.registration.showNotification(payload.title || 'LYVA Community', {
      body: payload.body || 'Ada pesan baru di chat komunitas.',
      icon: payload.icon || '/pwa-192.png',
      badge: payload.badge || '/favicon-32.png',
      tag: payload.tag || 'lyva-chat-message',
      renotify: true,
      data: {
        url: payload.url || '/chat',
      },
    }),
  );
});

async function networkFirst(request) {
  const cache = await caches.open(RUNTIME_CACHE);

  try {
    const response = await fetch(request);

    if (response && response.ok) {
      cache.put(request, response.clone());
    }

    return response;
  } catch (error) {
    const cached = await cache.match(request);

    if (cached) {
      return cached;
    }

    const offline = await caches.match('/offline.html');

    return offline || Response.error();
  }
}

async function cacheFirst(request) {
  const cached = await caches.match(request);

  if (cached) {
    return cached;
  }

  const response = await fetch(request);

  if (response && response.ok) {
    const cache = await caches.open(RUNTIME_CACHE);
    cache.put(request, response.clone());
  }

  return response;
}
