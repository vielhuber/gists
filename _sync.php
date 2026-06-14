<?php
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$headers = ['Authorization' => 'token ' . getenv('TOKEN'), 'User-Agent' => 'gists'];
$count = ['public' => 0, 'private' => 0];
// collect all gists in memory first; only persist to disk after a fully successful run
$collected = [];
$url = 'https://api.github.com/gists?page=1&per_page=100';
while ($url !== null) {
    echo $url . PHP_EOL;
    $response = __curl($url, null, 'GET', $headers);
    if (__nx(@$response->headers['link'][0])) {
        print_r($response);
        echo 'ERROR: missing link header, aborting' . PHP_EOL;
        exit(1);
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
        $gistResponse = __curl('https://api.github.com/gists/' . $result__value->id, null, 'GET', $headers);
        $gist = $gistResponse->result;
        if (__nx(@$gist->files)) {
            echo 'ERROR: failed to fetch gist ' . $result__value->id . ' (HTTP ' . $gistResponse->status . '), aborting' . PHP_EOL;
            print_r($gist);
            exit(1);
        }
        $folder = 'gists/' . str_replace(['/', '<', '>', ':', '"', '\\', '|', '?', '*'], '', $gist->description);
        foreach ($gist->files as $files__value) {
            // strip path separators (and the same illegal chars as the folder) so an
            // attacker-controlled gist filename cannot traverse out of the gists folder
            $filename = str_replace(['/', '<', '>', ':', '"', '\\', '|', '?', '*'], '', $files__value->filename);
            $collected[$folder][$filename] = $files__value->content;
        }
    }
    usleep(150000);
}
print_r($count);
// all fetches succeeded — replace the gists folder atomically from the user's perspective
__rrmdir('gists');
@mkdir('gists');
foreach ($collected as $folder => $files) {
    @mkdir($folder);
    foreach ($files as $filename => $content) {
        file_put_contents($folder . '/' . $filename, $content);
    }
}
