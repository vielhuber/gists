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
	return $this->belongsTo('App\Models\Bar', 'bar_id', 'id');
}
```
```php
Bar:
public function foos() {
	return $this->hasMany('App\Models\Foo', 'bar_id', 'id');
}
```

```php
Bar (only first):
public function foos() {
	return $this->hasOne('App\Models\Foo', 'bar_id')->latest(); // ->oldest()
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
      'App\Models\Bar',
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
      'App\Models\Foo',
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
    'App\Models\Bar',
    'App\Models\Gnarr',
    'foo_id',
    'gnarr_id'
);
```

hasManyThrough has no built in inverse!