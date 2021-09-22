## add to head
  
```html
<!-- pwa -->
<link rel="manifest" href="_pwa/manifest.json" />
<meta name="theme-color" content="#000000" />
<link rel="apple-touch-icon" href="_pwa/icon-192x192.png" />
<script>
    window.addEventListener('load', () => {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('_pwa/sw.js', { scope: '/' });
        }
    });
</script>
<!-- end of pwa -->
```

## create 5 icons

- `_pwa/icon-192x192.png`: transparent icon in size 192x192
- `_pwa/icon-256x256.png`: transparent icon in size 256x256
- `_pwa/icon-384x384.png`: transparent icon in size 384x384
- `_pwa/icon-512x512.png`: transparent icon in size 512x512
- `_pwa/icon-maskable.png`: icon generated with https://maskable.app/

## _pwa/manifest.json

```json
{
    "theme_color": "#000000",
    "background_color": "#ff00e1",
    "display": "standalone",
    "scope": "/",
    "start_url": "/index.html",
    "dir": "ltr",
    "lang": "de",
    "name": "appname",
    "short_name": "appname",
    "description": "appname",
    "orientation": "portrait",
    "icons": [
        {
            "src": "/_pwa/icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/_pwa/icon-256x256.png",
            "sizes": "256x256",
            "type": "image/png"
        },
        {
            "src": "/_pwa/icon-384x384.png",
            "sizes": "384x384",
            "type": "image/png"
        },
        {
            "src": "/_pwa/icon-512x512.png",
            "sizes": "512x512",
            "type": "image/png"
        },
        {
            "src": "/_pwa/icon-maskable.png",
            "sizes": "196x196",
            "type": "image/png",
            "purpose": "any maskable"
        }
    ]
}
```

## _pwa/sw.js

```js
const OFFLINE_VERSION = 1;
const CACHE_NAME = 'offline';
const OFFLINE_URL = 'offline.html';

self.addEventListener('install', (event) => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            await cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
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
    if (event.request.mode === 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    const preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                        return preloadResponse;
                    }
                    const networkResponse = await fetch(event.request);
                    return networkResponse;
                } catch (error) {
                    const cache = await caches.open(CACHE_NAME);
                    const cachedResponse = await cache.match(OFFLINE_URL);
                    return cachedResponse;
                }
            })()
        );
    }
});
```

## _pwa/offline.html

```html
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,minimum-scale=1" />
        <title>offline</title>
        <script>
            window.addEventListener('load', (e) => {
                document.querySelector('.reload').addEventListener('click', () => {
                    window.location.reload();
                });
                window.addEventListener('online', () => {
                    window.location.reload();
                });
                async function checkNetworkAndReload() {
                    try {
                        const response = await fetch('.');
                        if (response.status >= 200 && response.status < 500) {
                            window.location.reload();
                            return;
                        }
                    } catch {}
                    window.setTimeout(checkNetworkAndReload, 2500);
                }
                checkNetworkAndReload();
            });
        </script>
        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            html {
                font-family: Verdana, Geneva, sans-serif;
                color: #fff;
                background-color: #000;
            }
            .container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .title {
                font-size: 25px;
                margin-bottom: 25px;
            }
            .reload {
                font-size: 16px;
                display: block;
                padding: 10px 20px;
                background-color: #fff;
                color: #000;
                text-decoration: none;
                font-weight: bold;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="title">you are offline</h1>
            <a class="reload" href="#">reload</a>
        </div>
    </body>
</html>
```

## _pwa/.htaccess

- this allows the service worker js to be in a subdirectory

```
Header add Service-Worker-Allowed /
```

## test

- web developer > lighthouse > progressive web app
- web developer > network > offline