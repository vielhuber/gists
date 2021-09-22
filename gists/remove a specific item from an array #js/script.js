let a = ['foo', 'bar', null, 'baz'];

delete a[1]; // ['foo', undefined, null, 'baz']

a = a.filter(v => typeof v !== 'undefined'); // ['foo', null, 'baz']

a = a.filter(v => v != 'baz'); // ['foo', null]