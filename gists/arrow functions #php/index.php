### before
array_map(function($v) { return 'php '.$v.' will be fun'; }, ['7.4'])

### after
array_map(fn($v) => 'php '.$v.' will be fun', ['7.4'])