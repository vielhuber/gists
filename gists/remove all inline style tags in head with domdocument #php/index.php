<?php
$html = <<<EOD
<!DOCTYPE html><html lang="de"><head><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" /><title>.</title><style>.foo { }</style><style>.bar { }</style><style>.baz { }</style></head><body></body></html>
EOD;

// sometimes this is needed (when &gt;script is available instead of <script)
$html = htmlspecialchars_decode($html);

$dom = new \DOMDocument();
@$dom->loadHTML($html);
$nodeList = $dom->getElementsByTagName('head')->item(0)->getElementsByTagName('style');
for($nodeIdx = $nodeList->length; --$nodeIdx >= 0; )
{
    $node = $nodeList->item($nodeIdx);
    $node->parentNode->removeChild($node);
}
$html = $dom->saveHtml();
echo $html;
