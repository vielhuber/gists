<?php
require_once __DIR__ . '/vendor/autoload.php';
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

try {
    $puppeteer = new Puppeteer([
        /* 'executable_path' => '/root/.nvm/versions/node/v12.10.0/bin/node' (https://github.com/nesk/puphpeteer/issues/65) */
    ]);

    $args = [
        '--disable-gpu',
        '--disable-dev-shm-usage',
        '--disable-setuid-sandbox',
        '--no-first-run',
        '--no-sandbox',
        '--no-zygote',
        '--single-process',
    ];

    $proxy = (object) [
        'ip' => 'xxx',
        'port' => 'xxx',
        'username' => 'xxx',
        'password' => 'xxx',
    ];
    $proxy = null;

    if ($proxy !== null) {
        $args[] = '--proxy-server=' . $proxy->ip . ':' . $proxy->port;
    }

    $browser = $puppeteer->launch([
        'ignoreHTTPSErrors' => true,
        'args' => $args,
    ]);
    $page = $browser->newPage();
  	$this->page->setDefaultNavigationTimeout(5000);
    if ($proxy !== null) {
        $page->authenticate([
            'username' => $proxy->username,
            'password' => $proxy->password,
        ]);
    }
  	disableImages();    
    $page->setViewport(['width' => 1920, 'height' => 1080]);
  
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
    $browser->close();
} catch (\Exception $e) {
    echo $e->getMessage();
}

/* helpers */
function go($url)
{
    global $page;
    $page->goto($url, ['waitUntil' => 'networkidle2']);
}
function disableImages()
{
  global $page;
  $page->setRequestInterception(true);
  $page->on(
    'request',
    JsFunction::createWithParameters(['request'])->body(
      'request.resourceType() === "image" ? request.abort() : request.continue()'
    )
  );
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
        JsFunction::create(
            'return { html: new XMLSerializer().serializeToString(document) };'
        )
    );
    return htmlentities($response['html']);
}
