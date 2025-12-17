#### newest

```js
isPageSpeed() {
    if (
        navigator.userAgent.match(
            /(Mozilla\/5\.0 \(Linux; Android 11; moto g power \(2022\)\) AppleWebKit\/537\.36 \(KHTML, like Gecko\) Chrome\/109\.0.0.0 Mobile Safari\/537\.36)|(Mozilla\/5\.0 \(Macintosh; Intel Mac OS X 10_15_7\) AppleWebKit\/537\.36 \(KHTML, like Gecko\) Chrome\/109\.0\.0\.0 Safari\/537\.36)|(Speed Insights)|(Chrome-Lighthouse)|(PSTS[\d\.]+)/
        )
    ) {
        return true;
    }
    if (/HeadlessChromium|Lighthouse|PTST/.test(navigator.userAgent)) {
        return true;
    }
    if (navigator.webdriver) {
        return true;
    }
    if (navigator.plugins.length === 0) {
        return true;
    }
    if (!navigator.languages || navigator.languages.length === 0) {
        return true;
    }
    return false;
}
```

#### working (see: https://github.com/GoogleChrome/lighthouse/blob/main/core/config/constants.js#L83)
```js
if( navigator.userAgent.match(/(Mozilla\/5\.0 \(Linux; Android 11; moto g power \(2022\)\) AppleWebKit\/537\.36 \(KHTML, like Gecko\) Chrome\/109\.0.0.0 Mobile Safari\/537\.36)|(Mozilla\/5\.0 \(Macintosh; Intel Mac OS X 10_15_7\) AppleWebKit\/537\.36 \(KHTML, like Gecko\) Chrome\/109\.0\.0\.0 Safari\/537\.36)|(Speed Insights)|(Chrome-Lighthouse)|(PSTS[\d\.]+)/) ) { }
```

```htaccess
RewriteCond %{HTTP_USER_AGENT} (Mozilla\/5\.0\ \(Linux;\ Android\ 11;\ moto\ g\ power\ \(2022\)\)\ AppleWebKit\/537\.36\ \(KHTML,\ like\ Gecko\)\ Chrome\/109\.0.0.0\ Mobile\ Safari\/537\.36)|(Mozilla\/5\.0\ \(Macintosh;\ Intel\ Mac\ OS\ X\ 10_15_7\)\ AppleWebKit\/537\.36\ \(KHTML,\ like\ Gecko\)\ Chrome\/109\.0\.0\.0\ Safari\/537\.36)|(Speed\ Insights)|(Chrome-Lighthouse)|(PSTS[\d\.]+) [NC,OR] # desktop and mobile
```

#### deprecated
```js
if (navigator.userAgent.indexOf('Speed Insights') > -1 || navigator.userAgent.indexOf('Chrome-Lighthouse') > -1) { }
```

#### deprecated
```js
if (navigator.language === 'en-US' && navigator.platform.indexOf('Linux') > -1) { }
if (window.innerWidth < 768 || navigator.userAgent.indexOf('Chrome-Lighthouse') > -1) { }
```