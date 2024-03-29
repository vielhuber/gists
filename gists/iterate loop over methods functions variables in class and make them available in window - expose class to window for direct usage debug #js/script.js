export default class Test
{
  	constructor() { }
	a() { }
    static b() { }
}

// expose whole class for direct usage in browser
if (typeof window !== 'undefined') {
	window.Test = Test;
}

// static
if (typeof window !== 'undefined') {
  window.Test = {};
  Object.getOwnPropertyNames(Test).forEach((value, key) =>
  {
      // do something, e.g. make methods available in browser
      if( value === 'length' || value === 'name' || value === 'prototype' || value === 'caller' || value === 'arguments' ) { return; }
      window.Test[value] = Test[value];
  });
  // dynamic props
  Object.getOwnPropertyNames(Test.prototype).forEach((value, key) =>
  {

  });
}