import Example from './example';

Example.staticFunction();
Example.staticVar;

let e = new Example();
e.dynamicFunction();
alert(e.var1);
alert(e.dynamicVar);