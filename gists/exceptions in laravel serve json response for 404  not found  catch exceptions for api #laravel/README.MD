- we catch all exceptions on api level
- now we can manually call wherever we want in the code:
- the middleware handles all that and outputs the data (based on if it's local or not)

```php
// this is not shown publically
__exception('foo')
__exception(['foo'=>'bar'])
throw new \Exception('baz')

// this is shown publically
__exception(['message'=>'server error #133', 'public_message' => 'Spezieller öffentlicher Fehler', 'data' = []])
```