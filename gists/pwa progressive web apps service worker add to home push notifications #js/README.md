## PWAs (Progressive Web Apps)
- Mutation of existing pages to apps
- Can be installed via add to home, android app store or even cross platform on windows/linux
- Important for google pagespeed lighthouse
- Can also be used for normal php cms sites to cache static assets
- Tools: https://www.pwabuilder.com, https://serviceworke.rs, https://developers.google.com/web/tools/workbox

#### Service Worker
- Installs itself for the first time
- Client side proxy
- Freely programmable
- Takes care of caching, offline usage etc.
- Writes to a offline database that is included for free
- Mainly works via events (because the Browser always can stop the Service Worker, so he only listens)
- Implementation is very easy, but infrastructure, edge cases are quite complex (you have to orchestrate everything)

#### Manifest file
- Controls some settings for name, short name, start url, view mode, colors, icons
- <link> tag in main website points to this manifest file
- These are "wishes", the browsers interpret those and apply some in very special ways

#### Add to home button
- Browser UI is in the background or configurale
- iOS never shows add to home button
- Android only shows add to home button if certain conditions are fulfilled (e.g. a Service Worker has to be present)

#### Push notifications
- Backend server that initiates the push message and that contacts os specific push services
- These services send the messages and notify the service worker
- The service worker can be waken up and it shows the push noticiations
- here some manual work is necessary: is the app currently open or not etc.
- in the main app only one line of code is necessary: show the push notification in the ui

#### Cached data
- IndexedDB is a very good fit for storing client side data in a service worker
- The npm package `idb` is a convenient wrapper for interacting with the database
- See: https://gist.github.com/vielhuber/2a56f14400b0031ee0c2a146e5123ee9

#### Links
- https://www.youtube.com/watch?v=baSiSIyTGSk
- https://maskable.app/
- https://www.pwabuilder.com/
- https://mobiforge.com/design-development/pwa-minimus-a-minimal-pwa-checklist
- https://web.dev/offline-fallback-page/
- https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/Offline_Service_workers
- https://jakearchibald.com/2014/offline-cookbook/#network-falling-back-to-cache
- https://css-tricks.com/serviceworker-for-offline/