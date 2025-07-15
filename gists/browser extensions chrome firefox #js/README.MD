## Local installation

#### Chrome

- Install local addon: `chrome://extensions` > Load packed extension > Choose folder with extension files in it
- Reload local addon: `chrome://extensions` > Reload icon
- Addon for fast reload: [Extensions Reloader](https://chromewebstore.google.com/detail/extensions-reloader/fimgfedafeadlieiabdeeaodndnlbhid)

#### Firefox

- Install local addon ([autoload-temporary-addon](https://github.com/tsaost/autoload-temporary-addon))
  - Copy [config-prefs.js](https://raw.githubusercontent.com/tsaost/autoload-temporary-addon/refs/heads/main/config-prefs.js) to `C:\Program Files\Mozilla Firefox\defaults\pref\`
  - Copy [userChrome.js](https://raw.githubusercontent.com/tsaost/autoload-temporary-addon/refs/heads/main/userChrome.js) to `C:\Program Files\Mozilla Firefox\`
  - Apply fixes: [pull/3](https://github.com/tsaost/autoload-temporary-addon/pull/3) & [pull/7](https://github.com/tsaost/autoload-temporary-addon/pull/7)
  - Modify code: `function installUnpackedExtensions() { installExtension("C:\\path\\to\\extension", true); }`
  - Debug `userChrome.js`: CTRL+Shift+I > Settings > "Enable browser chrome and add-on debugging toolboxes" and "Enable remote debugging" => CTRL+Alt+Shift+I
- Reload local addon: `about:debugging`

## Files

#### `/manifest.json`

```json
{
    "manifest_version": 3,
    "name": "🚀My custom extension🚀",
    "description": "Lorem ipsum dolor sit amet.",
    "version": "42",
    "permissions": ["storage"],
    "host_permissions": ["<all_urls>"],
    "background": {
        "service_worker": "background.js",
        "scripts": ["background.js"]
    },
    "icons": {
        "128": "icon.png"
    },
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["script.js"],
            "css": ["style.css"]
        }
    ]
}
```

#### `/icon.png`

- 128px x 128px

#### `/style.css`

```css
/* this gets applied on every page! */
.foo {
    box-shadow: 10px 10px 10px red;
}
```

#### `/script.js`

```js
(async () => {
  
  	/* basic examples */
  	alert('foo');  
  	document.body.style.opacity = '0.5';  
  	setInterval(() => {
        if (document.querySelector('.foo') !== null) {
          document.querySelectorAll('.foo').forEach($el => {
            $el.remove();
          });
        }
    }, 1000);
  
  	/* set/get permanent data */
    await chrome.storage.local.set({
      ['my_custom_global_key']: {
        foo: 'bar',
        bar: 'baz'
      }
    });  
  	await chrome.storage.local.get('my_custom_global_key'); // { foo: 'bar', bar: 'baz' }
  
  	/* fetch with service worker in background.js */
    let response = await new Promise((resolve, reject) => {
      chrome.runtime.sendMessage(
        {
          action: 'https://tld.com/foo/bar',
          data: {
            url: url,
            args: {
              method: 'GET',
              headers: {
                Authorization: 'Bearer 42'
              }
            }
          }
        },
        response => {
          resolve(response);
        }
      );
    });
  	console.log(response);

})();
```

#### `/background.js`

```js
chrome.runtime.onMessage.addListener(function (message, sender, senderResponse) {
    if (message.action === 'fetch') {
        fetch(message.data.url, message.data.args)
            .then(response => {
                let data = response.json(),
                    status = response.status;
                if (status == 200 || status == 304) {
                    return data;
                }
                return { success: false, message: status };
            })
            .catch(error => {
                return { success: false, message: error };
            })
            .then(response => {
                senderResponse(response);
            });
        return true;
    }
});
```
