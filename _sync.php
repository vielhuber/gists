<?php
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$headers = ['Authorization' => 'token ' . getenv('TOKEN'), 'User-Agent' => 'gists'];
$count = ['public' => 0, 'private' => 0];
__rrmdir('gists');
mkdir('gists');
$url = 'https://api.github.com/gists?page=1&per_page=100';
while ($url !== null) {
    echo $url . PHP_EOL;
    $response = __curl($url, null, 'GET', $headers);
    if (__nx(@$response->headers['link'][0])) {
        print_r($response);
        break;
    }
    $url = null;
    foreach (explode(', ', $response->headers['link'][0]) as $link__value) {
        if (strpos($link__value, 'rel="next"') !== false) {
            $url = substr($link__value, strpos($link__value, '<') + 1, strpos($link__value, '>') - 1);
        }
    }
    foreach ($response->result as $result__value) {
        if (!__true($result__value->public)) { $count['private']++; continue; }
        $count['public']++;
        $gist = __curl('https://api.github.com/gists/' . $result__value->id, null, 'GET', $headers)->result;
        $folder = 'gists/' . str_replace(['/', '<', '>', ':', '"', '\\', '|', '?', '*'], '', $gist->description);
        mkdir($folder);
        foreach ($gist->files as $files__value) {
            file_put_contents($folder . '/' . $files__value->filename, $files__value->content);
        }
    }
    sleep(0.25);
}
print_r($count);
