```regex
(?:http(?:s)?:\/\/)?(?:www\.)?(?:.*)?(?:\.)(?:[a-z]+?(?:\/|$))([^?]*?)(?:\/$|\/\?|\/$|$|\?)
```

- https://www.tld.com/foo/bar/?gfjhgfjhgfhjf => "foo/bar"
- www.tld.com/foo/bar/?jhhg => "foo/bar"
- http://tld.com => ""
- tld.com/foo/bar => "foo/bar"
- tld.com => ""