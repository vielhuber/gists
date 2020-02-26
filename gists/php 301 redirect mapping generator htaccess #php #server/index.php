<?php
require_once 'spout/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

$rules = [];

$reader = ReaderFactory::create(Type::XLSX);
$reader->open('input.xlsx');
foreach ($reader->getSheetIterator() as $sheets__key => $sheets__value) {
    foreach ($sheets__value->getRowIterator() as $rows__key => $rows__value) {
        if ($rows__key === 1) {
            continue;
        }
        if (@$rows__value[0] == '') {
            continue;
        }
        $target = $rows__value[0];
      	// if needed
      	$target = get_redirect_final_target($target);
        $target = str_replace(['http://test.tld.com/', 'https://test.tld.com/'], 'https://www.tld.com/', $target);
        foreach ($rows__value as $rows__value__key => $rows__value__value) {
            if ($rows__value__key === 0) {
                continue;
            }
            if ($rows__value__value !== '') {
                $source = $rows__value__value;
                if (strrpos($source, '/') === strlen($source)-1) {
                    $source = substr($source, 0, strrpos($source, '/'));
                }
                // strip ?
                if(strrpos($source, '?') !== false)
                {
                    $source = substr($source, 0, strrpos($source, '?'));
                }
                // prevent endless loops
                $endless_loop_source = str_replace(['http://www.tld.com','https://www.tld.com'], '', $source);
                $endless_loop_target = str_replace(['http://www.tld.com','https://www.tld.com'], '', $target);
                if (strrpos($endless_loop_target, '/') === strlen($endless_loop_target)-1) {
                    $endless_loop_target = substr($endless_loop_target, 0, strrpos($endless_loop_target, '/'));
                }
                if( $endless_loop_source === $endless_loop_target )
                {
                    continue;
                }
                // rel links
                $source = str_replace(['http://www.tld.com/','https://www.tld.com/'], '', $source);
              	// escape spaces
              	if( strpos($source, ' ') !== false ) {
                 	$source = str_replace(' ', '\ ', $source); 
                }
                $rules[] = [$source, $target];
            }
        }
    }
}
$reader->close();

/*
echo '<pre>';
print_r($rules);
*/

$htaccess = '';
$htaccess .= '<IfModule mod_rewrite.c>' . PHP_EOL;
$htaccess .= 'RewriteEngine On' . PHP_EOL;
foreach ($rules as $rules__value) {
    $htaccess .=
        'RewriteRule ^' . $rules__value[0] . '\/?$ ' . $rules__value[1] . ' [R=301,L]' . PHP_EOL;
}
$htaccess .= '</IfModule>';
file_put_contents('.htaccess', $htaccess);
die('ok');

function get_redirect_final_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'username:password');
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
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
