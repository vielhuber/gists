<?php
require_once __DIR__ . '/vendor/autoload.php';
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

$browser = null;

try {
    $args = [];
    if (@$_SERVER['SERVER_ADMIN'] === 'david@close2.de' || @$_SERVER['NAME'] === 'DAVID-DESKTOP') {
      $args['executable_path'] = '/root/.nvm/versions/node/v12.10.0/bin/node'; // https://github.com/nesk/puphpeteer/issues/65
    }
    $puppeteer = new Puppeteer($args);

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
  	$page->setDefaultTimeout(5000);
    if ($proxy !== null) {
        $page->authenticate([
            'username' => $proxy->username,
            'password' => $proxy->password,
        ]);
    }
  	disableImagesAndStylesheets();    
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
    innerHTML('.baz');
    shot();
    $browser->close();
} catch (\Exception $e) {
    echo $e->getMessage();
}
finally {
  if ($browser !== null) {
    $browser->close();
  }
}

/* helpers */
function go($url)
{
    global $page;
    $page->tryCatch->goto($url, ['waitUntil' => 'networkidle2']);
}
function disableImagesAndStylesheets()
{
  global $page;
  $page->setRequestInterception(true);
  $page->on(
    'request',
    JsFunction::createWithParameters(['request'])->body(
      'request.resourceType() === "image" || request.resourceType() === "stylesheet" || request.resourceType() === "font" ? request.abort() : request.continue()'
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
function innerHTML($selector) {
  	global $page;
    return $page->querySelectorEval(
      $selector,
      JsFunction::createWithParameters(['e'])->body('return e.innerHTML')
    );
}
