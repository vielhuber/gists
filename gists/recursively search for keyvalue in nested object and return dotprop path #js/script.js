function findRecursiveInObject(object, key = null, value = null, path = '', paths = []) {
    if( object !== null && typeof object === 'object' )
    {
        for(const [object__key, object__value] of Object.entries(object)) {
        	if( object__value !== null && typeof object__value === 'object' )
          {
          	findRecursiveInObject(object__value, key, value, ((path==='')?(''):(path+'.'))+object__key, paths);
          }
					else if( (key === null || object__key === key) && (value === null || object__value === value) )
          {
          	paths.push(path);
            break; // only take first
          }
        }
    }
    return paths;
}

var object = {
  foo:
  {
  	bar: 20,
    id: 20
  },
  bar:
  {
  	progress: 20,
    id: 20,
    ok: 'NO'
  },
  baz: {
  	foo: {
     		bar: {
        	ok: 'NO',
          no: {
          	id: 20
          },
          yes: {
          	id: 21
          }
        }
    }
  }
};

console.log(findRecursiveInObject(object, 'id'));
console.log(findRecursiveInObject(object, 'id', 20));
console.log(findRecursiveInObject(object, null, 21));