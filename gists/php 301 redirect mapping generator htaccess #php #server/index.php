<?php
require_once __DIR__ . '/vendor/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

$config = [
    'input' => 'internal_html.xlsx',
    'skip_first_line' => false,
    'follow_redirects' => false,
    'domains' => [
        'old' => 'tld.de',
        'new' => 'www.tld.de',
        'test' => 'tld.dev'
    ]
];

$rules = [];
$reader = ReaderEntityFactory::createXLSXReader();
$reader->open($config['input']);
foreach ($reader->getSheetIterator() as $sheets__key => $sheets__value) {
    foreach ($sheets__value->getRowIterator() as $rows__key => $rows__value) {
        $cells = $rows__value->toArray();
        if ($config['skip_first_line'] === true && $rows__key === 1) {
            continue;
        }
        if (@$cells[0] == '') {
            continue;
        }
        $source = null;
        $target = null;
        $endless_loop = false;
        foreach (['source', 'target'] as $type__key => $type__value) {
            ${$type__value} = $cells[$type__key];
            if ($config['follow_redirects'] === true) {
                ${$type__value} = get_redirect_final_target(${$type__value});
            }
            foreach ($config['domains'] as $domains__value) {
                foreach (['http://', 'http://www.', 'https://', 'https://www.'] as $protocol__value) {
                    ${$type__value} = str_replace($protocol__value . $domains__value, '', ${$type__value});
                }
            }
            // strip "/"
            ${$type__value} = trim(${$type__value}, '/');
            // strip ?
            if (strrpos(${$type__value}, '?') !== false) {
                ${$type__value} = mb_substr(${$type__value}, 0, strrpos(${$type__value}, '?'));
            }
            // prevent endless loops
            if ($type__value === 'target' && stripslashes($source) === ${$type__value}) {
                $endless_loop = true;
                break;
            }
            // escape
            if ($type__value === 'source') {
                foreach (
                    ['\\', '.', '^', '$', '*', '+', '-', '?', '(', ')', '[', ']', '{', '}', '|', ' ']
                    as $chars__value
                ) {
                    ${$type__value} = str_replace($chars__value, '\\' . $chars__value, ${$type__value});
                }
            }
            // use abs url on target
            if ($type__value === 'target') {
                ${$type__value} = 'https://' . $config['domains']['new'] . '/' . ${$type__value};
            }
        }
        if ($endless_loop === false) {
            $rules[] = [$source, $target];
        }
    }
}
$reader->close();

$htaccess = '';
$htaccess .= '<IfModule mod_rewrite.c>' . PHP_EOL;
$htaccess .= 'RewriteEngine On' . PHP_EOL;
foreach ($rules as $rules__value) {
    $htaccess .= 'RewriteRule ^' . $rules__value[0] . '\/?$ ' . $rules__value[1] . ' [R=301,L]' . PHP_EOL;
}
$htaccess .= '</IfModule>';
file_put_contents('.htaccess', $htaccess);
echo $htaccess;
die();

function get_redirect_final_target($url)
{
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_USERPWD, 'username:password');
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target) {
        return $target;
    }
    return false;
}
