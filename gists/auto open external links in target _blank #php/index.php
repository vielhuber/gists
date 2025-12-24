<?php
/* helper function */
function isExternalUrl($url)
{
    // check for .pdf (all pdfs should open in external window)
    if (preg_match('/\.pdf(\?.*)?$/', $url) === 1) { return true; }
    // check for relative paths, mailto: or tel:
    if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) { return false; }
    // strip protocol
    $pattern = '/^(http(s)?:\/\/)?(www\.)?/';
    $url = preg_replace($pattern, '', $url);
    $host = preg_replace($pattern, '', $_SERVER['HTTP_HOST']);
    return strpos($url, $host) !== 0;
}

/* usage */
$url = 'http://sandbox.onlinephpfunctions.com/fgdfgd.pdf';
//echo '<a href="'.$url.'"'.(isExternalUrl($url)?(' target="_blank"'):('')).'></a>';

/* tests */
$url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'];
$tests = [
    ['/', false],
    ['/blub/', false],
    [$url.'/blub', false],
    [$url.'/blub/', false],
    [$url.'/file.pdf', true],
    [$url.'/file.pdf?', true],
    [$url.'/file.pdf?query=string', true],
    [$url.'/file.pdfing', false],
    [$url.'/file.pdf.php', false],
    [$url.'/file.pdf.php?query=string', false],
    ['https://'.$_SERVER['HTTP_HOST'], false],
    ['https://www.'.$_SERVER['HTTP_HOST'], false],
    [$url, false],
    ['mailto:info@example.com', false],
    ['tel:+49123456', false],
    ['http://example.local', true],
    ['http://www.example.local', true],
    ['https://www.example.local', true],
    ['https://example.local', true],
];
foreach($tests as $tests__value)
{
    if(isExternalUrl($tests__value[0]) !== $tests__value[1])
    {
      echo 'FAILED (detected as ' . ($tests__value[1] ? 'external' : 'interal') . '): ' . $tests__value[0] . PHP_EOL;
    }
    else
    {
      echo 'SUCCEEDED (detected as ' . ($tests__value[1] ? 'external' : 'interal') . '): ' . $tests__value[0] . PHP_EOL;
    }
}