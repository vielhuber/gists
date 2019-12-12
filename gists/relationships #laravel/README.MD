### basic relationship

```txt
foos
    id
    bar_id
bars
    id
```

```php
Foo:
public function bar() {
	return $this->belongsTo('App\Bar', 'bar_id');
}
```
```php
Bar:
public function foos() {
	return $this->hasMany('App\Foo', 'bar_id');
}
```

### with intermediate table

```txt
foos
    id
bars
    id
foos_bars
    id
    foo_id
    bar_id
```

```php
Foo:
public function bars() {
  return $this->belongsToMany(
      'App\Bar',
      'foo_bar',
      'foo_id',
      'bar_id'
  );
}
```

```php
Bar:
public function foos() {
  return $this->belongsToMany(
      'App\Foo',
      'foo_bar',
      'bar_id',
      'foo_id'
  );
}
```

### has many through

```txt
foos
    id
bars
    id
    gnarr_id
gnarrs
    id
    foo_id
```

```php
Foo:
return $this->hasManyThrough(
    'App\Bar',
    'App\Gnarr',
    'foo_id',
    'gnarr_id'
);
```

hasManyThrough has no built in inverse!