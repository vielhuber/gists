<?php
require_once __DIR__ . '/vendor/autoload.php';
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use Nesk\Rialto\Exceptions\Node;

class Browser
{
    private $browser = null;
    private $page = null;
    private $shot_i = 1;

    public function init()
    {
        try {
            $args = [];
            if (@$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de' || @$_SERVER['NAME'] === 'DAVID-DESKTOP') {
                $args['executable_path'] = '/root/.nvm/versions/node/v16.17.0/bin/node'; // https://github.com/nesk/puphpeteer/issues/65
            }
            $puppeteer = new Puppeteer($args);
            $args = [
                '--disable-gpu',
                '--disable-dev-shm-usage',
                '--disable-setuid-sandbox',
                '--no-first-run',
                '--no-sandbox',
                '--no-zygote',
                '--single-process'
            ];
            $proxy = (object) [
                'ip' => 'xxx',
                'port' => 'xxx',
                'username' => 'xxx',
                'password' => 'xxx'
            ];
            $proxy = null;
            if ($proxy !== null) {
                $args[] = '--proxy-server=' . $proxy->ip . ':' . $proxy->port;
            }
            $this->browser = $puppeteer->launch([
                'headless' => false,
                'ignoreHTTPSErrors' => true,
                'args' => $args,
              	//'userDataDir' => '/tmp/myChromeSession', // only important for subsequent sessions where devices should be remembered
            ]);
            $this->page = $this->browser->newPage();
            $this->page->setDefaultTimeout(10000);
            if ($proxy !== null) {
                $this->page->authenticate([
                    'username' => $proxy->username,
                    'password' => $proxy->password
                ]);
            }
            $this->disableImagesAndStylesheets();

            $this->page->setViewport(['width' => 1920, 'height' => 1080]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function go($url)
    {
        $this->page->tryCatch->goto($url, ['waitUntil' => 'networkidle2']);
    }

    private function disableImagesAndStylesheets()
    {
        $this->page->setRequestInterception(true);
        $this->page->on(
            'request',
            (new JsFunction(['request']))->body(
                'request.resourceType() === "image" || request.resourceType() === "stylesheet" || request.resourceType() === "font" ? request.abort() : request.continue()'
            )
        );
    }

    public function close()
    {
        $this->browser->close();
    }

    public function shot()
    {
        $this->page->screenshot(['path' => 'live_' . str_pad($this->shot_i++, 4, '0', STR_PAD_LEFT) . '.png']);
    }

    public function wait($selector)
    {
        if (is_int($selector)) {
            usleep($selector * 1000);
        } else {
            $this->page->tryCatch->waitForSelector($selector, ['timeout' => 3000]);
        }
    }

    public function exists($selector)
    {
        try {
            $this->page->tryCatch->waitForSelector($selector, ['timeout' => 3000]);
            return true;
        } catch (Node\Exception $e) {
            return false;
        }
    }

    public function click($selector)
    {
      	$this->wait($selector);
        try {
            $this->page->tryCatch->click($selector);
        } catch (Node\Exception $e) {
            // see https://stackoverflow.com/a/66537619/2068362
            $this->page->querySelectorEval($selector, (new JsFunction(['b']))->body('b.click()'));
        }
    }

    public function type($field, $value)
    {
      	$this->wait($selector);
        $this->page->type($field, $value);
    }

    public function html()
    {
        $response = $this->page->evaluate(
            new JsFunction([], 'return { html: new XMLSerializer().serializeToString(document) };')
        );
        return htmlentities($response['html']);
    }

    public function innerHTML($selector)
    {
        return $this->page->querySelectorEval($selector, (new JsFunction(['e']))->body('return e.innerHTML'));
    }
}

$b = new Browser();
$b->init();

$b->go('https://tld.com');

$b->wait('.login-form');
$b->type('.login-form__input--email', 'xxx');
$b->type('.login-form__input--password', 'xxx');
$b->shot();
$b->click('.login-form__submit');

//$b->wait('.foo'); // not needed, since click waits automatically
$b->click('.foo');
$b->shot();

$b->wait(1000);
$b->wait('.bar');
$b->shot();

$b->wait('.baz');
$b->innerHTML('.baz');
$b->shot();

$b->html();

$b->close();
