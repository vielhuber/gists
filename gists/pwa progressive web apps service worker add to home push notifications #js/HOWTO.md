## add to head
  
```html
<!-- pwa -->
<link rel="manifest" href="_pwa/manifest.json" />
<meta name="theme-color" content="#000000" />
<link rel="apple-touch-icon" href="_pwa/icon-192x192.png" />
<script>
  	// register service worker
    window.addEventListener('load', () => {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('_pwa/sw.js', { scope: '/' });
        }
    });

    // helper method to get variables from the service worker
    // example: await getValueFromServiceWorker('VERSION')
    async getValueFromServiceWorker(key) {
        return new Promise(async (resolve) => {
            // wait until the controller is ready (this is important especially on first load)
            while (navigator.serviceWorker.controller === null) {
                await new Promise((resolve) => setTimeout(() => resolve(), 1000));
            }
            navigator.serviceWorker.controller.postMessage({ type: 'request-val', key: key });
            let fn = (event) => {
                if (event.data.type === 'receive-val' && event.data.key === key) {
                    navigator.serviceWorker.removeEventListener('message', fn, false);
                    resolve(event.data.value);
                }
            };
            navigator.serviceWorker.addEventListener('message', fn);
        });
    }
</script>
<!-- end of pwa -->
```

## create 5 icons

- `_pwa/icon-192x192.png`: transparent icon in size 192x192
- `_pwa/icon-256x256.png`: transparent icon in size 256x256
- `_pwa/icon-384x384.png`: transparent icon in size 384x384
- `_pwa/icon-512x512.png`: transparent icon in size 512x512
- `_pwa/icon-maskable.png`: icon with background (without corners) in size 192x192 with content a little bit shrinked (85%); checked with https://maskable.app/ (minimum safe area / circle)

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
            "sizes": "192x192",
            "type": "image/png",
            "purpose": "any maskable"
        }
    ]
}
```

## _pwa/sw.js

```js
// configuration options
self.VERSION = 14; // increase number to update the service worker itself (not the assets, they are controlled in the "activate" section)
//self.VERSION = Date.now(); // only for debugging reasons(!)
let CACHE_NAME = 'UniqueName'+self.VERSION;
let SUBFOLDER = 'app';

// if you really need to import external scripts, you can do something like
//self.importScripts('idb-keyval.js'); // copy https://cdn.jsdelivr.net/npm/idb-keyval@6/dist/umd.js to idb-keyval.js

self.addEventListener('install', (event) => {
    event.waitUntil(
        (async () => {
            // open cache
            let cache = await caches.open(CACHE_NAME);
            // add assets to cache on installation
            // this has nothing to do with caching assets
            // this is done below in the cached section of the fetch listener
            let assets = [
                // manifest should also be cached
                '/_pwa/manifest.json',
                // icons should also be cached
                '/_pwa/icon-192x192.png',
                '/_pwa/icon-256x256.png',
                '/_pwa/icon-384x384.png',
                '/_pwa/icon-512x512.png',
                '/_pwa/icon-maskable.png',
                // all other static assets
                '/style.css',
                '/script.js',
                '/index.html',
                // this is needed also
                '/'
            ];
            cache.addAll(assets.map(assets__value => '/'+SUBFOLDER+assets__value));
            // add offline page (only if you follow the offline-strategy in the fetch event listener)
            await cache.add(new Request('offline.html', { cache: 'reload' }));
        })()
    );

    // replace old service worker
    self.skipWaiting();
});

// this is run *NOT* on every page reload(!)
self.addEventListener('activate', (event) => {
    // new feature: navigation preload
    event.waitUntil(
        (async () => {
            if ('navigationPreload' in self.registration) {
                await self.registration.navigationPreload.enable();
            }
        })()
    );

    // tell the active service worker to take control of the page immediately
    self.clients.claim();
});

// intercept fetch calls
// be aware: this also catches static requests and also the initial page request
self.addEventListener('fetch', (event) => {

    // only handle GET requests (never POST, since we want to always do this in the frontend, because we don't want to mess with Requests/Responses)
    if (event.request.method !== 'GET') {
        return;
    }

    // exclude certain dynamic routes from caching (we want to handle the error in the client javascript, not here
    else if (event.request.url.match(/\/api\.php$/)) {
        return false;
    }
  
    // SPA strategy: always serve shell index when offline (ignoring GET URL parameters)
    if (event.request.mode === 'navigate' && event.request.headers.get('accept').includes('text/html')) {
        event.respondWith(
            (async () => {
                try {
                    let preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                        return preloadResponse;
                    }
                    let networkResponse = await fetch(event.request);
                    return networkResponse;
                } catch (error) {
                    let cache = await caches.open(CACHE_NAME);
                    let cachedResponse = await cache.match('/' + SUBFOLDER + '/index.html', { ignoreSearch: true });
                    return cachedResponse;
                }
            })()
        );
    }

    // GET strategy: network first, always update cache, cache fallback
    else {
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
    }
  
    // different strategy: always serve offline page
    else if (event.request.mode === 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    // try navigation preload
                    let preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                       return preloadResponse;
                    }
                    // try network
                    let networkResponse = await fetch(event.request);
                    return networkResponse;
                }
                catch (error) {
                    // if exception (network error), return offline page
                    let cache = await caches.open(CACHE_NAME);
                    let cachedResponse = await cache.match(OFFLINE_URL);
                    return cachedResponse;
                }
            })()
        );
    }

});

// helper to fetch variables from the service worker
self.addEventListener('message', (event) => {
    if (event.data.type === 'request-val') {
        self.clients.matchAll().then((clients) => {
            clients.forEach((client) => {
                client.postMessage({ type: 'receive-val', key: event.data.key, value: self[event.data.key] });
            });
        });
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
                        let response = await fetch('.');
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

## .htaccess

- this disables http caching, but not service worker caching (e.g. for style.css and script.js)

```
# disable http caching
Header set Cache-Control "no-cache, no-store, must-revalidate"
Header set Pragma "no-cache"
Header set Expires 0

# add this if you request from a specific subfolder
<If "%{HTTP_REFERER} =~ m#app#">
Header set Cache-Control "no-cache, no-store, must-revalidate"
Header set Pragma "no-cache"
Header set Expires 0
</If>
```

## debug in web developer tools

- Application > Service Workers > Offline
- Application > Storage > Clear site data
- Lighthouse > Progressive Web App
- Network > Offline
