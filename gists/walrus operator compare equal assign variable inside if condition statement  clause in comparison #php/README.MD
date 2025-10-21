- `=` is both a *statement* and an *expression*
- `$a = 'foo'` assigns `'foo'` to `$a` *and* evaluates always to the right side (`'foo'`)
- if the right side is truthy (not `''`, `0`, `[]`, `null`, `false`), then you enter the if statement

```php 
// simple
function get_some_field() { return 'foo'; }
if( $a = get_some_field() ) {
 	echo $a; // foo
} // warning, $a is always 'foo' here, even if the condition was falsy!
 
// multiple
function get_some_field_1() { return null; }
function get_some_field_2() { return null; }
function get_some_field_3() { return 'foo'; }
if( $a = get_some_field_1() ?? get_some_field_2() ?? get_some_field_3() ) {
 	echo $a; // foo
}

// complex
function get_some_field() { return 'bar'; }
if( ($a = get_some_field()) === 'bar' ) {
    echo $a; // bar
}

// real
if( ($foo = Foo::where('foo','bar')) && $foo->count() > 0 ) {
  dd($foo->get());
}
```