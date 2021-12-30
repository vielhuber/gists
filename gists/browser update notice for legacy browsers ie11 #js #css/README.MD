### notes
- be aware: don't  include browserUpdate into your build script (because it can crash on old browsers)
- always include it before all other scripts are included (on top of head)

### embed in head (safest approach)
```html
<script> 
var $buoop = { /* options see below */ }; 
function $buo_f() { var e = document.createElement('script'); e.src = '//browser-update.org/update.min.js'; document.body.appendChild(e); };
try {document.addEventListener('DOMContentLoaded', $buo_f,false)}
catch(e){window.attachEvent('onload', $buo_f)}
</script>
```

```php
// wordpress: functions.php
add_action('wp_head', function () { ?>
    <script> 
    var $buoop = { /* ... */ };
    function $buo_f() { var e = document.createElement('script'); e.src = '//browser-update.org/update.min.js'; document.body.appendChild(e); };
    try {document.addEventListener('DOMContentLoaded', $buo_f,false)}
    catch(e){window.attachEvent('onload', $buo_f)}
    </script>
  	<style>
  	html.browserupdate--active { }
	/* ... */
  	</style>
<?php }, -9999 );
```

### directly embed in js
```sh
npm install browser-update --save
```

```js
var browserUpdate = require('browser-update');
browserUpdate({ /* options see below */ });
```

### options
```js
{
    required: { i: 99, e: 80, f: -4, o: -4, s: -1, c: -4 },
    reminder: 0, // always show (if no user interaction); set this to 0 if you always show it
    reminderClosed: 0, // show after 1 hour again (after user interaction); set this to 0 if you always show it
    insecure: false,
    api: 2021.12,
    test: false, // test with true or with #test-bu
    shift_page_down: false,
    no_permanent_hide: true,
  	noclose: true,
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
}
```

### styling

```scss
html.browserupdate--active {
    /* reduce opacity in background */
    .buorg ~ *,
    .chefcookie {
      opacity: 0.1 !important;
      pointer-events: none !important;
    }
}
html {
  	/* increase z-index */
  	.buorg {
    	z-index: 2147483647;  
  	}
    /* colors */
    .buorg,
    .buorg b,
    .buorg strong {
        color: #fff;
    }
    /* hide icon */
    .buorg-icon {
        /*display: none;*/
    }
    .buorg {
        background-color: #283340;
        border-bottom: 1px solid #a29330;
    }
    #buorgig,
    #buorgul,
    #buorgpermanent {
        color: #fff;
        background: #3baa85;
      	border-radius:0;
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