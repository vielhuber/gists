let foo;

foo = null;
foo?.bar?.baz // undefined

foo = null;
if( foo?.bar?.baz ) { console.log('42'); } else { console.log('7'); } // 7

foo = { bar: { baz: 'gnarr' } };
if( foo?.bar?.baz ) { console.log('42'); } else { console.log('7'); } // 42

foo = null;
foo?.bar?.baz??'no value' // no value

foo = true;
foo?.bar?.baz??'no value' // no value

foo = false;
foo?.bar?.baz??'no value' // no value

foo = { bar: { baz: 'gnarr' } };
foo?.bar?.baz??'no value' // gnarr

true??'42' // true
false??'42' // false
null??'42' // 42
undefined??'42' // 42