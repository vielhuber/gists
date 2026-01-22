let VERSION = 14;
VERSION = Date.now(); // debug
const CACHE_NAME = 'UniqueName'+VERSION;
const SUBFOLDER = 'app';

self.addEventListener('install', (event) => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            let assets = [
                '/_pwa/manifest.json',
                '/_pwa/icon-192x192.png',
                '/_pwa/icon-256x256.png',
                '/_pwa/icon-384x384.png',
                '/_pwa/icon-512x512.png',
                '/_pwa/icon-maskable.png',
                '/style.css',
                '/script.js',
                '/index.html',
                '/'
            ];
            cache.addAll(assets.map(assets__value => '/'+SUBFOLDER+assets__value));
        })()
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        (async () => {
            if ('navigationPreload' in self.registration) {
                await self.registration.navigationPreload.enable();
            }
        })()
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }
    if (event.request.url.match(/\/api\.php$/)) {
        return false;
    }
    event.respondWith(
        (async () => {
            try {
                let response = await fetch(event.request),
                    cache = await caches.open(CACHE_NAME);
                cache.put(event.request, response.clone());
                return response;
            } catch (err) {
                let response = caches.match(event.request);
                return response;
            }
        })()
    );
});
