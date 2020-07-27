<?php
### setup
```php
$DOMDocument = new \DOMDocument();
$DOMDocument->loadHTML('<div>foo</div>');
$DOMXPath = new \DOMXPath($DOMDocument);
```

### load html file
```php
$DOMDocument->loadHTML(file_get_contents('tpl.html'));
```

### load html file (with or without header)
```php
// if the html source doesn't contain a valid utf8 header, domdocument interprets is as iso
// we circumvent this with mb_convert_encoding
// warning: if you don't add a doctype/html tag, domdocument adds that information for you
// also if only a text node is provided, it is surrounded by a p-tag
// we also add <meta http-equiv="content-type" content="text/html;charset=utf-8" /> got proper encoding (see below)
$html = file_get_contents('tpl.html');
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$has_wrapper = strpos($html, '<html') !== false;
if ($has_wrapper === false) { $html = '<!DOCTYPE html><html data-please-remove-wrapper><body>' . $html . '</body></html>'; }
if (mb_strpos($html, '</head>') !== false) { $html = str_replace('</head>', '<!--remove--><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><!--/remove--></head>', $html); }
elseif (mb_strpos($html, '<body') !== false) { $html = str_replace('<body', '<!--remove--><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /></head><!--/remove--><body', $html); }
else { $html = '<!--remove--><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /></head><!--/remove-->' . $html; }
@$DOMDocument->loadHTML($html);
```

### get back html from domdocument
```php
// domdocument does not close empty li tags (because they're valid html)
// to circumvent that, use:
$nodes = $DOMXPath->query('/html/body//*[not(node())]');
foreach($nodes as $nodes__value) { $nodes__value->nodeValue = ''; }
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
// if domdocument added previously a default header, we squish that
if (mb_stripos($html, 'data-please-remove-wrapper') !== false) {
  $pos1 = mb_strpos($html, '<body>') + mb_strlen('<body>');
  $pos2 = mb_strpos($html, '</body>');
  $html = mb_substr($html, $pos1, $pos2 - $pos1);
}
```

### query nodes
```php
$nodes = $DOMXPath->query('/html/body//*[@id="foo"]');
foreach($nodes as $nodes__value) {
    /* ... */
}
```

### get all nodes (including text nodes)
```php
$DOMXPath->query('/html/body//node()');
$DOMXPath->query('/html/body//node()[normalize-space()]'); // exclude whitespace text nodes
```

### get text nodes only
```php
$DOMXPath->query('/html/body//text()');
$DOMXPath->query('/html/body//text()[normalize-space()]'); // exclude whitespace text nodes
```

### class selector
```php
$DOMXPath->query('/html/body//*[contains(concat(" ", normalize-space(@class), " "), " foo ")]');
```

### id selector
```php
$DOMXPath->query('/html/body//*[@id="root"]');
```

### attribute selector
```php
$DOMXPath->query('/html/body//input[@placeholder]');
```

### attribute value selector
```php
$DOMXPath->query('/html/body//a[starts-with(@href, 'tel:')]);
```

### attribute selector (key wildcard)
```php
$DOMXPath->query('/html/body//@*[starts-with(name(), \'data-\')]/parent::*');
```
 
### check if is text node
```php
if($node->nodeName === '#text') {}
```
 
### get tag name of node
```php
$node->tagName
```
 
### get/set content of text value
```php
// difference: https://stackoverflow.com/questions/12380919/php-dom-textcontent-vs-nodevalue
$node->nodeValue
$node->textContent

// this is important: domdocument set strings with encoded html chars
// for text nodes as plain text (and not html)
// we therefore use the parent node and set the node value accordingly
$node->parentNode->nodeValue = 'That&#39;s cool';
// if you don't want to lose the text node, you can do:
$node->nodeValue = html_entity_decode('That&#39;s cool', ENT_QUOTES | ENT_XML1, 'UTF-8');
```

### get children of node (recursively)
```php
$DOMXPath->query('.//node()', $node);
$DOMXPath->query('.//node()[normalize-space()]', $node); // exclude whitespace text nodes
```
 
### get children count of node (recursively)
```php
$DOMXPath->evaluate('count(./node())', $node);
$DOMXPath->evaluate('count(./node()[normalize-space()])', $node); // exclude whitespace text nodes
```

### get attributes of node beginning with "data-"
```php
$attrs = $this->DOMXPath->query('./@*[starts-with(name(),"data-")]', $node);
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
$nodes = $DOMXPath->query('/html/body//node()');
foreach ($nodes as $nodes__value) {
    $id = intval($DOMXPath->evaluate('count(.//following::node()|.//child::node())',$nodes__value))+1;
];
```

### get unique id of node (way faster)
```php
$nodes = $DOMXPath->query('/html/body//node()');
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
