## PWAs (Progressive Web Apps)
- mutation of existing pages to apps
- can be installed via add to home, android app store or even cross platform on windows/linux
- important for google pagespeed lighthouse
- can also be used for normal php cms sites to cache static assets
- tools: https://www.pwabuilder.com, https://serviceworke.rs, https://developers.google.com/web/tools/workbox

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
