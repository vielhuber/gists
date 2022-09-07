### installation
- Add files to new (private) GitHub repo

**index.js**
```js
const express = require('express'),
    app = express(),
    port = process.env.PORT || 3000;
app.get('/', (req, res) => {
    res.send('Hello World!');
});
app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`);
});
```

**package.json**
```json
{
    "name": "example",
    "version": "1.0.0",
    "main": "index.js",
    "scripts": {
        "start": "node index.js"
    },
    "engines": {
        "node": "12.x"
    },
    "dependencies": {
        "@prettier/plugin-php": "^0.16.1",
        "express": "^4.17.1",
        "prettier": "^2.2.1"
    }
}
```

**Procfile**
```
web: node index.js
```

- Create app 
  - https://dashboard.heroku.com/apps
  - New > Create new app
  - App name, Region: Europe
- Deploy
  - Deployment method: GitHub
  - Automatic deploys: Enable Automatic Deploys (master)
- Test
  - Make new commit and push to master
  - Access at https://example.herokuapp.com
  - You also can manually deploy from current master (under "Deploy")
  - Watch build logs under "Activity"
- Restart
  - ```heroku restart --app example```
- PHP/Apache Support
  - Add a new buildpack ```heroku/php```
  - Add a ```composer.json```: (```{ "require": { "php": "^8.0.0" } }```) file
  - Change the ```Procfile``` to ```web: vendor/bin/heroku-php-apache2``` or ```web: vendor/bin/heroku-php-apache2 public/```
- Buildpacks
  - If you need special buildpacks, add them via Settings > Buildpacks
  - You can add multiple buildpacks at once, if your app needs multiple requirements
  - If you want to use e.g. puppeteer, use https://elements.heroku.com/buildpacks/jontewks/puppeteer-heroku-buildpack
  - Basic requirements like express does not explicitly need a buildpack
- Logs / CMD
  - ```heroku login```
  - ```heroku run pwd --app example```
  - ```heroku logs --tail --app example```
- Wakeup
  - Free dynos sleep after 30 minutes and then need ~10 secs to wake up
  - To prevent that: Resources > Add-ons > "Heroku Scheduler" > "Standard - Free" > Open link > Create job > "curl -s https://example.herokuapp.com/" > Every 10 minutes