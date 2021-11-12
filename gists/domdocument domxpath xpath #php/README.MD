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

### check length of query
```php
$nodes = $DOMXPath->query('/html/body//*[@id="foo"]');
if( $nodes->length > 0 ) {}
if( count($nodes) > 0 ) {}
```

### get first item
```php
$nodes = $DOMXPath->query('/html/body//*[@id="foo"]');
if( $nodes->length > 0 ) { $node = $nodes[0]; }
```

### types of selectors
- `node()`: any node (including text nodes)
- `text()`: text nodes
- `comment()`: comment nodes
- `*`: dom nodes
- `node()[normalize-space()]`: any node (including text nodes) excluding whitespace text nodes (and also including <br/>)
- `text()[normalize-space()]`: any text node excluding whitespace
- `/html/body//*|/html/body//text()[normalize-space()]`: dom nodes and test nodes (without whitespace)

### get all nodes (including text nodes)
```php
$DOMXPath->query('/html/body//node()');
```

### get all nodes (without text nodes)
```php
$DOMXPath->query('/html/body//*');
```

### get text nodes only
```php
$DOMXPath->query('/html/body//text()');
```

### class selector
```php
$DOMXPath->query('/html/body//*[contains(concat(" ", normalize-space(@class), " "), " foo ")]');
```

### id selector
```php
$DOMXPath->query('/html/body//*[@id="root"]');
```

### tag selector
```php
$DOMXPath->query('/html/body//input');
```

### multiple tag selector
```php
$DOMXPath->query('/html/body//input|/html/body//select');
```

### tag selector
```php
$DOMDocument->getElementsByTagName('input');
```

### attribute selector
```php
$DOMXPath->query('/html/body//input[@placeholder]');
```

### attribute value selector
```php
$DOMXPath->query('/html/body//a[@href="#"]);
```

### attribute value selector
```php
$DOMXPath->query('/html/body//a[starts-with(@href, 'tel:')]);
```

### attribute selector (key wildcard)
```php
$DOMXPath->query('/html/body//@*[starts-with(name(), \'data-\')]/parent::*');
```

### next sibling selector ".foo + .bar"
```php
$DOMXPath->query('//*[contains(concat(" ", normalize-space(@class), " "), " foo ")]/following::*[contains(concat(" ", normalize-space(@class), " "), " bar ")]');
``` 

### check if is text node
```php
if($node->nodeName === '#text') {}
if($node->nodeType === 3) {}
```

### check if is dom/element node
```php
if($node->nodeType === 1) {}
```
 
### get tag name of node
```php
$node->tagName
```
 
### get/set content of text node
```php
// difference: https://stackoverflow.com/questions/12380919/php-dom-textcontent-vs-nodevalue
$node->nodeValue
$node->textContent
// reading (this is important): if you fetch the variable of a text node with nodeValue (or even textContent) and also getAttribute
// the content is automatically is encoded (what we usually don't want)
// we use htmlentities (or the even weaker htmlspecialchars) to revert that
htmlentities($node->nodeValue)
htmlspecialchars($node->nodeValue)
// writing (this is important): domdocument sets strings with encoded html chars for text nodes as plain text (and not html)
// we therefore use the parent node and set the node value accordingly (so that the encoded strings are properly set)
$node->parentNode->nodeValue = 'That&#39;s cool';
// if you really want to use the text node, you can do:
$node->nodeValue = html_entity_decode('That&#39;s cool', ENT_QUOTES | ENT_XML1, 'UTF-8');
```

### get children of node (recursively)
```php
$DOMXPath->query('.//node()', $node);
```

### get children count of node (recursively)
```php
$DOMXPath->evaluate('count(./node())', $node);
```

### get text siblings (including oneself if text node) node
```php
$DOMXPath->query('./../text()[normalize-space()]', $node);
```

### get text siblings that are longer than 3 chars
```php
$DOMXPath->query('./../text()[normalize-space()][string-length() > 3]', $node);
```

### get text siblings that are longer than 1 char (excluding whitespace)
```php
$DOMXPath->query('./../text()[normalize-space()][string-length(normalize-space(.)) > 1]', $node);
```

### get dom elements without content inside (empty tags)
```php
$DOMXPath->query('/html/body//*[not(node())][not(text())]')
```

### get direct sibling of node
```php
$DOMXPath->query('(./following-sibling::*|./following-sibling::text()[normalize-space()])[1]', $node);
$DOMXPath->query('(/html/body//*[@id="foo"]/following-sibling::*|/html/body//*[@id="foo"]/following-sibling::text()[normalize-space()])[1]');
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

### check if dom attribute exists
```php
$node->hasAttribute('foo');
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

### add / append child
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

### insert before
```php
$node->parentNode->insertBefore($newNode, $node);
```

### insert after
```
if($node->nextSibling === null) { $node->parentNode->appendChild($newNode); }
else { $node->parentNode->insertBefore($newNode, $node->nextSibling);  }
```

### copy clone node
```php
$node->cloneNode(true)
```

### remove node
```php
$node->parentNode->removeChild($node);
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
    $inner .= $node->ownerDocument->saveHTML($child);
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

### string to single node
```php
$DOMDocument = new \DOMDocument(); // master dom document (needed for reference)
$str = mb_convert_encoding($str, 'HTML-ENTITIES', 'UTF-8');
$tmp = new \DOMDocument();
$tmp->loadHTML($str, LIBXML_HTML_NOIMPLIED);
$node = $DOMDocument->importNode($tmp->documentElement,true);
```

### replace node with string
```php
$str = '<strong>String that replaces the node</strong>';
$tmp = new \DOMDocument();
$str = mb_convert_encoding($str, 'HTML-ENTITIES', 'UTF-8');
$tmp->loadHTML($str, LIBXML_HTML_NOIMPLIED);
$repl = $DOMDocument->importNode($tmp->documentElement, true);
$node->parentNode->replaceChild($repl, $node);
```

### load xml
```php
$DOMDocument = new \DOMDocument();
@$DOMDocument->loadXML($html);
$DOMXPath = new \DOMXPath($DOMDocument);
```

### write xml
```php
$html = $DOMDocument->saveXML();
```

### if domdocument is from xml
```php
if($dom->xmlVersion != '') {}
```

### search in all namespaces
```php
$DOMXPath->query('//loc'); // this does not work, if the <loc> nodes are inside a socalled namespace (<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">)
$DOMXPath->query('//*[name()=\'loc\']'); // this works in all namespaces
```