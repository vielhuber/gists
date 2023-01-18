## installation

`npm install -g backstopjs`

- a global installation is recommended

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

```.env
BACKSTOPJS_URL=https://tld.com
```

`backstop.config.js`

```js
require('dotenv').config();
const url = process.env.BACKSTOPJS_URL;
module.exports = {
    scenarios: [
        {
            label: 'Test',
            url: url
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
        await page.goto('https://tld.com/login');
        if (await page.$('input[name="username"]') !== null) {
          await page.type('input[name="username"]', '***'); // even better: process.env.TEST_USER
          await page.type('input[name="password"]', '***'); // even better: process.env.TEST_PASSWORD
          await page.click('input[type="submit"]');
          await page.waitForNavigation();
        }
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
      //"url": urls__value.replace('https://','https://username:password@'),
      //"delay": 3000 // wait after load for x seconds (good to be sure everything is loaded)
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