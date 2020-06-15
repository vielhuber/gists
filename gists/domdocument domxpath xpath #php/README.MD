<?php
### setup
```php
$DOMDocument = new \DOMDocument();
$DOMDocument->loadHTML('<div>foo</div>');
$DOMXpath = new \DOMXpath($DOMDocument);
```

### load html file
```php
$DOMDocument->loadHTML(file_get_contents('tpl.html'));
```

### load html file (without header)
```php
// if the html source doesn't contain a valid utf8 header, domdocument interprets is as iso
// we circumvent this with mb_convert_encoding
// warning: if you don't add a doctype/html tag, domdocument adds that information for you
// also if only a text node is provided, it is surrounded by a p-tag
// we also add <meta http-equiv="content-type" content="text/html;charset=utf-8" /> got proper encoding (see below)
$input = file_get_contents('tpl.html');
$input = mb_convert_encoding($input, 'HTML-ENTITIES', 'UTF-8');
if (mb_strpos($html, '</head>') !== false) { $html = str_replace('</head>', '<!--remove--><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><!--/remove--></head>', $html); }
elseif (mb_strpos($html, '<body') !== false) { $html = str_replace('<body', '<!--remove--><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /></head><!--/remove--><body', $html); }
else { $html = '<!--remove--><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /></head><!--/remove-->' . $html; }
@$DOMDocument->loadHTML($input);
```

### get back html from domdocument
```php
$html = $DOMDocument->saveHTML();
// domdocument converts all umlauts to html entities, revert that
// $html = html_entity_decode($html); 
// this method is bad when we use intentionally encoded code e.g. in <pre> tags; another option to prevent html entities (and leave everything intact)
// is to add <meta http-equiv="content-type" content="text/html;charset=utf-8" /> (see above)
// warning: this still encodes < to &gt; because < is invalid html!
// undo above changes
if (mb_strpos($html, '<!--remove-->') !== false && mb_strpos($html, '<!--/remove-->') !== false) {
    $html = mb_substr($html, 0, mb_strpos($html, '<!--remove-->')) . mb_substr($html, mb_strpos($htmlModified, '<!--/remove-->') + mb_strlen('<!--/remove-->'));
}
```

### get all nodes (including text nodes)
```php
$DOMXpath->query('/html/body//node()');
$DOMXpath->query('/html/body//node()[normalize-space()]'); // exclude whitespace text nodes
```

### get text nodes only
```php
$DOMXpath->query('/html/body//text()');
$DOMXpath->query('/html/body//text()[normalize-space()]'); // exclude whitespace text nodes
```

### class selector
```php
$DOMXpath->query('/html/body//*[contains(concat(" ", normalize-space(@class), " "), " foo ")]');
```

### id selector
```php
$DOMXpath->query('/html/body//*[@id="root")]');
```

### attribute selector
```php
$DOMXpath->query('/html/body//input[@placeholder]');
```

### attribute selector (key wildcard)
```php
$DOMXpath->query('/html/body//@*[starts-with(name(), \'data-\')]/parent::*'');
```
 
### check if is text node
```php
if($node->nodeName === '#text') {}
```
 
### get tag name of node
```php
$node->tagName
```
 
### get content of text value
```php
$node->nodeValue
```

### get content of text value
```php
$node->textContent
```

### get children of node (recursively)
```php
$DOMXpath->query('.//node()', $node);
$DOMXpath->query('.//node()[normalize-space()]', $node); // exclude whitespace text nodes
```
 
### get children count of node (recursively)
```php
$DOMXpath->evaluate('count(./node())', $node);
$DOMXpath->evaluate('count(./node()[normalize-space()])', $node); // exclude whitespace text nodes
```

### get attributes of node beginning with "data-"
```php
$attrs = $this->DOMXpath->query('./@*[starts-with(name(),"data-")]', $node);
if (!empty($attrs)) {
    echo $attrs__value->nodeName;
    echo $attrs__value->nodeValue;
}
```
 
### get dom attribute
```php
$node->getAttribute('foo');
```
 
### set dom attribute
```php
$node->setAttribute('foo','bar');
```

### get unique id of node (this is very neat for comparing nodes etc)
```php
$nodes = $DOMXpath->query('/html/body//node()');
foreach ($nodes as $nodes__value) {
	$id = intval($DOMXpath->evaluate('count(.//following::node()|.//child::node())',$nodes__value))+1;
];
```

### get unique id of node (way faster)
```php
$nodes = $DOMXpath->query('/html/body//node()');
foreach ($nodes as $nodes__value) {
	$id = $nodes__value->getNodePath();
];
```

### add child
```php
$child = $DOMDocument->createElement('a', '');
$child->setAttribute('href', 'https://tld.com');
$parent->appendChild($child);
```

### prepend child
```php
if ($parent->hasChildNodes()) {
    $parent->insertBefore($child,$parent->firstChild);
} else {
    $parent->appendChild($child);
}
```

### get outer html of node
```php
$doc = new \DOMDocument();
$doc->appendChild($doc->importNode($node, true));
echo $doc->saveHTML();
```

### get inner html of node
```php
$inner = '';
foreach ($node->childNodes as $child) {
	$inner .= $node->ownerDocument->saveXML($child);
}
return $inner;
```

### set inner html of node
```php
for ($x = $node->childNodes->length - 1; $x >= 0; $x--) {
    $node->removeChild($node->childNodes->item($x));
}
if ($value != '') {
    $f = $node->ownerDocument->createDocumentFragment();
    $result = @$f->appendXML($value);
    if ($result) {
        if ($f->hasChildNodes()) {
            $node->appendChild($f);
        }
    } else {
        $f = new \DOMDocument();
        $value = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
        $result = @$f->loadHTML('<htmlfragment>' . $value . '</htmlfragment>');
        if ($result) {
            $import = $f->getElementsByTagName('htmlfragment')->item(0);
            foreach ($import->childNodes as $child) {
                $importedNode = $node->ownerDocument->importNode($child, true);
                $node->appendChild($importedNode);
            }
        } else {
        }
    }
}
```
