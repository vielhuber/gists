## installation

`npm install -g backstopjs`

- a global installation is recommended

`npm update -g backstopjs`

- be careful when upgrading: compare the folder `backstop_data/engine_scripts/puppet` with the newest version (sometimes things change there also!)

`backstop --version`

- show current version

`backstop init`

- setup boilerpolate files

`.gitignore`

```
/backstop_data/html_report/
/backstop_data/bitmaps_test/
/backstop_data/bitmaps_reference/
```

## usage

`backstop test`

- compares current version with referenced version
- opens browser

`backstop approve`

- declares current version as referenced version

### js config file

- recommended way
- rename `backstop.json` to `backstop.config.js`
- prepend with `module.exports = `
- run command with `backstop test --config="backstop.config.js"`
- add alias to `package.json`: `"scripts": { "test": "backstop test --config=\"backstop.config.js\"", "test:ok": "backstop approve --config=\"backstop.config.js\"" }`

### dynamic urls

`npm install dotenv`

`.env`

```.env
BACKSTOPJS_URL=https://tld.com
```

`backstop.config.js`

```js
require('dotenv').config();
const base_url = process.env.BACKSTOPJS_URL;
module.exports = {
    scenarios: [
        {
            label: 'Test',
            url: base_url.replace(/^\/+|\/+$/g, '') + '/' + 'test'.replace(/^\/+|\/+$/g, ''),
        }
    ]
}
```

### authentication

`backstop.config.js`

```js
scenarios: [
    {
        label: 'Logged in',
        url: 'https://tld.com',
        login: false
    },
    {
        label: 'Logged out',
        url: 'https://tld.com',
        login: true
    }
]
```

`backstop_data/engine_scripts/puppet/onBefore.js`

```
module.exports = async (page, scenario, vp) => {
    await require('./loadCookies')(page, scenario);
    if (scenario.login === true) {
        await page.goto('https://tld.com/login'); // even better: process.env.BACKSTOPJS_URL
        if (await page.$('input[name="username"]') !== null) {
          await page.type('input[name="username"]', '***'); // even better: process.env.BACKSTOPJS_USERNAME
          await page.type('input[name="password"]', '***'); // even better: process.env.BACKSTOPJS_PASSWORD
          await page.click('[type="submit"]');
          await page.waitForNavigation();
        }
    }
};
```

### extract urls in separate file

#### backstop.config.js

```js
let backstop_tests = require('./backstop.tests');
backstop_tests.tests.forEach(tests__value => {
	/* ... */
}
```

#### backstop.tests.js

```js
module.exports = {
    tests: [
        { url: '/' },
        /* ... */
    ]
};
```

### run js code before / hide content

#### backstop.config.js

```js
let tests = [
    '/test1',
    '/test2',
    {
        url: '/test3',
      	login: true,
        hide: ['.foo', '.bar'],
        remove: ['.baz', '.gnarr'],
        input: [['input[name="first_name"]', 'Test']],
        click: ['input[type="submit"]'],
        js: () => { document.querySelector('img').style.opacity = 0.5; }
    }
];
require('dotenv').config();
const base_url = process.env.BACKSTOPJS_URL;
let scenarios = [];
tests.forEach((tests__value) => {
    let target_url, login, hide, remove, input, click, js;
    if (typeof tests__value === 'object') {
        target_url = 'url' in tests__value ? tests__value.url : null;
        login = 'login' in tests__value ? tests__value.login : false;
        hide = 'hide' in tests__value ? tests__value.hide : [];
        remove = 'remove' in tests__value ? tests__value.remove : [];
        input = 'input' in tests__value ? tests__value.input : [];
        click = 'click' in tests__value ? tests__value.click : [];
        js = 'js' in tests__value ? tests__value.js : null;
    } else {
        target_url = tests__value;
        login = false;
        hide = [];
        remove = [];
        input = [];
        click = [];
        js = null;
    }
    scenarios.push({
        // label must be unique but determinstic
        label: (target_url + '_' + Buffer.from(JSON.stringify([login, input, click])).toString('base64')).substring(
            0,
            100
        ),
        url: base_url.replace(/^\/+|\/+$/g, '') + '/' + target_url.replace(/^\/+|\/+$/g, ''),
        login: login,
        hideSelectors: hide,
        removeSelectors: remove,
        /* we don't use the native helper method "keyPressSelectors" since it does not replace inputs */
        //keyPressSelectors: [],
        input: input,
        /* we don't use the native helper method "clickSelectors" since it does not wait for reload */
        //clickSelectors: [],
        click: click,
        js: js
    });
});
```

#### onReady.js

```
module.exports = async (page, scenario, vp) => {
    /* ... */    
    await require('./clickAndHoverHelper')(page, scenario);
    /* ... */
    if (scenario.input !== null) {
        for (let input__value of scenario.input) {
            await page.waitForSelector(input__value[0]);
            //await page.type(input__value[0], input__value[1]);
            // clear and type (different behaviour as in clickAndHoverHelper)
            let input = await page.$(input__value[0]);
            await input.click({ clickCount: 3 });
            await input.type(input__value[1]);
        }
    }
    if (scenario.click !== null) {
        for (let click__value of scenario.click) {
            await page.waitForSelector(click__value);
            await page.click(click__value);
            // wait for navigation (different behaviour as in clickAndHoverHelper)
            await page.waitForNavigation();
        }
    }
    if (scenario.js !== null) {
        await new Promise((resolve) => setTimeout(() => resolve(), 1000));
        await page.evaluate(scenario.js);
    }
};
```

### use as a screenshot engine

```js
let urls = [];

// read from txt file
let fs = require('fs'),
    file = fs.readFileSync('urls.txt', 'utf-8');
    file.split(/\r?\n/).forEach(line => { urls.push(line); });

// read from array
/*
urls = [
    'https://tld.com/',
    'https://tld.com/foo/',
    'https://tld.com/foo/bar/'
];
*/

// generate with command line
/*
curl -N -s https://www.tld.com/sitemap_index.xml | grep -oP '<loc>\K[^<]*' | xargs -n1 curl -N -s | grep -oP '<loc>\K[^<]*' > urls.txt
*/

let scenarios = [];
urls.forEach(urls__value => {
    scenarios.push({
      "label": urls__value,
      "url": urls__value,
      // url: urls__value.replace('https://','https://username:password@'),
      // delay: 3000, // wait after load for x seconds (good to be sure everything is loaded)
      // misMatchThreshold: 0.01, // detect also very small differences
      // selectors: 'html', // important trick if page rendering does not work properly
    });
});

let viewports = [
    {
      "label": "desktop",
      "width": 1920,
      "height": 1080
    },
    /*
    {
      "label": "tablet_landscape",
      "width": 1024,
      "height": 768
    },
    {
      "label": "tablet_portrait",
      "width": 768,
      "height": 1024
    },
    {
      "label": "phone",
      "width": 320,
      "height": 568
    },
    */
];

module.exports = {
  "viewports": viewports,
  "scenarios": scenarios,
  "asyncCaptureLimit": 5, // how much parallel requests
  /* ... */
}
```

- `npm run test`
- look at /backstop_data/bitmaps_test/*