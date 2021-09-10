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
- add alias to `package.json`: `"scripts": { "test": "backstop test --config=\"backstop.config.js\"" }`

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
        await page.type('input[name="username"]', '***'); // even better: process.env.TEST_USER
        await page.type('input[name="password"]', '***'); // even better: process.env.TEST_PASSWORD
        await page.click('input[type="submit"]');
        await page.waitForNavigation();
    }
};
```
