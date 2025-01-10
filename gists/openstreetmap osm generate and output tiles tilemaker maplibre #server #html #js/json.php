<?php
if(!isset($_GET['file']) || !in_array($_GET['file'], ['metadata.json','style.json'])) { die(); }
header('Content-Type: application/json; charset=utf-8');
$url = ('http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST']);
$content = file_get_contents('./tiles/'.$_GET['file']);
if( $_GET['file'] === 'style.json' ) {
    $content = preg_replace('/"url": "(.+)\.json"/', '"url": "'.$url.'/json.php?file=metadata.json"', $content);
    $content = preg_replace('/"glyphs": "(.+)\/fonts\/\{fontstack\}\/\{range\}\.pbf"/', '"glyphs": "'.$url.'/tiles/fonts/{fontstack}/{range}.pbf"', $content);
    $content = preg_replace('/"sprite": "(.+)\/sprite"/', '"sprite": "'.$url.'/tiles/sprite"', $content);
}
if( $_GET['file'] === 'metadata.json' ) {
    $content = preg_replace('/"tiles":\["(.+)\/{z}\/{x}\/{y}.pbf"\]/', '"tiles":["'.$url.'/tiles/{z}/{x}/{y}.pbf"]', $content);
}
echo $content;
die();
