### controller

```php
/* ... */
public function getTestOverview()
   return view('test', [
      'foo' => function($str) { return $this->foo($str); }
   ]);
}

private function foo($str) {
   return $str.'baz';
}
/* ... */
```

### view

```php
{{ $foo('bar') }}
```