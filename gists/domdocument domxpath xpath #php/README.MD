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
@$DOMDocument->loadHTML(mb_convert_encoding(file_get_contents('tpl.html'), 'HTML-ENTITIES', 'UTF-8'));
```

### get back html from domdocument
```php
$html = $DOMDocument->saveHTML();
```

### get all nodes (including text nodes)
```php
$DOMXpath->query('/html/body//node()');
```

### get text nodes only
```php
$DOMXpath->query('/html/body//text()');
```

### class selector
```php
$DOMXpath->query('/html/body//*[contains(concat(" ", normalize-space(@class), " "), " foo ")]');
```

### attribute selector
```php
$DOMXpath->query('/html/body//input[@placeholder]');
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

### get children of node (recursively)
```php
$DOMXpath->query('.//node()', $node);
```
 
### get children count of node (recursively)
```php
$DOMXpath->evaluate('count(./node())', $node);
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
