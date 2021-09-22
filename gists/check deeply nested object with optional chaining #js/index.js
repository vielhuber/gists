let foo;
foo = {};
foo = { bar: { baz: { muh: 'gnarr' } } };

// old (1)
if( foo && foo.bar && foo.bar.baz && foo.bar.baz.muh )
{
	console.log( foo.bar.baz.muh );
}

// old (2)
try {
   console.log( foo.bar.baz.muh );
} catch(e) { }
                
// old (3)
console.log( (((foo || {}).bar || {}).baz || {}).muh );

// old (4)
dotProp(foo, 'bar.baz.muh')

// new (es proposal and typescript / babel support)
console.log( foo?.bar?.baz?.muh );