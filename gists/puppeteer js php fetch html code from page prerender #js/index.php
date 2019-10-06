<?php
require_once(__DIR__.'/vendor/autoload.php');
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
$puppeteer = new Puppeteer;
$browser = $puppeteer->launch();
$page = $browser->newPage();
$page->goto('https://skyronic.github.io/vue-spa/#/', [ 'waitUntil' => 'networkidle2' ]);
$response = $page->evaluate(JsFunction::create('return { html: new XMLSerializer().serializeToString(document) };'));
$browser->close();
echo htmlentities($response['html']);