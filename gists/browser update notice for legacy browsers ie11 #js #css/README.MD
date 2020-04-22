```bash
npm install browser-update --save
```

```js
var browserUpdate = require('browser-update');
browserUpdate({
    required: { e: -3, f: -3, o: -3, s: -1, c: -3 },
    reminder: 0, // always show (if no user interaction)
    reminderClosed: 1, // show after 1 hour again (after user interaction)
    insecure: true,
    api: 2020.04,
    test: true,
    shift_page_down: false,
    no_permanent_hide: true,
    newwindow: false,
    l: document.documentElement.getAttribute('lang'), // don't use browser lng but website lng
    url: 'https://bestvpn.org/outdatedbrowser/',
    onshow: function() {
        document.documentElement.classList.add(
            'browserupdate--active'
        );
    },
    onclose: function() {
        document.documentElement.classList.remove(
            'browserupdate--active'
        );
    },
    text_in_de: {
        msgmore:
            'Aktualisieren Sie Ihren Browser, damit diese Webseite fehlerfrei und sicher dargestellt werden kann.'
    },
    text_in_en: {
        msgmore:
            'Update your browser so that this website can be made error-free and secure.'
    },
    text_in_fr: {
        msgmore:
            'Mettez à jour votre navigateur afin que ce site Web puisse être rendu sans erreur et sécurisé.'
    }
});
```

```scss
html.browserupdate--active {
    /* reduce opacity in background */
    .buorg ~ * {
        opacity: 0.1;
        pointer-events: none;
    }
}
html {
    /* colors */
    .buorg,
    .buorg b,
    .buorg strong {
        color: #fff;
    }
    .buorg {
        background-color: #283340;
    }
    #buorgig,
    #buorgul,
    #buorgpermanent {
        color: #fff;
        background: #3baa85;
    }
    #buorgig {
        background-color: #edbc68;
    }
    /* reset font */
    .buorg {
        font: inherit;
    }
    /* more spacing */
    .buorg-buttons {
        margin-top: 10px;
    }
    .buorg-pad {
        padding: 20px;
    }
}
```