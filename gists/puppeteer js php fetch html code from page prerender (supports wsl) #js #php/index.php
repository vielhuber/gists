<?php
require_once(__DIR__.'/vendor/autoload.php');
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
$puppeteer = new Puppeteer;
$browser = $puppeteer->launch([
   'args' => [
        '--disable-gpu',
        '--disable-dev-shm-usage',
        '--disable-setuid-sandbox',
        '--no-first-run',
        '--no-sandbox',
        '--no-zygote',
        '--single-process',
   ]
]);
$page = $browser->newPage();
$page->goto('https://skyronic.github.io/vue-spa/#/', [ 'waitUntil' => 'networkidle2' ]);
$response = $page->evaluate(JsFunction::create('return { html: new XMLSerializer().serializeToString(document) };'));
$browser->close();
echo htmlentities($response['html']);

<?php
require_once __DIR__ . '/vendor/autoload.php';
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
$puppeteer = new Puppeteer([
    /* 'executable_path' => '/root/.nvm/versions/node/v12.10.0/bin/node' (https://github.com/nesk/puphpeteer/issues/65) */
]);
$browser = $puppeteer->launch([
    'args' => [
        '--disable-gpu',
        '--disable-dev-shm-usage',
        '--disable-setuid-sandbox',
        '--no-first-run',
        '--no-sandbox',
        '--no-zygote',
        '--single-process'
    ]
]);
$page = $browser->newPage();
$page->setViewport(['width' => 1920, 'height' => 1080]);

try {
    go('https://tld.com');
    wait('.login-form');
    shot();
    type('.login-form__input--email', 'xxx');
    shot();
    type('.login-form__input--password', 'xxx');
    shot();
    click('.login-form__submit');
    wait('.foo');
    shot();
    click('.foo');
    wait('.bar');
    wait(100);
    shot();
    wait('.baz');
    shot();
} catch (\Exception $e) {
}

$browser->close();

/* helpers */
function go($url)
{
    global $page;
    $page->goto($url, ['waitUntil' => 'networkidle2']);
}
function shot()
{
    global $page;
    $page->waitFor(1000);
    $page->screenshot(['path' => 'live.jpg']);
}
function wait($selector)
{
    global $page;
    $page->tryCatch->waitFor($selector, ['timeout' => 3000]);
}
function click($selector)
{
    global $page;
    $page->click($selector);
}
function type($field, $value)
{
    global $page;
    $page->type($field, $value);
}
function html()
{
    global $page;
    $response = $page->evaluate(
        JsFunction::create('return { html: new XMLSerializer().serializeToString(document) };')
    );
    return htmlentities($response['html']);
}
