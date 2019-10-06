export default class Example {
  
    // this now is also possible (with http://babeljs.io/docs/en/babel-plugin-transform-class-properties/)
    dynamicVar = 'foo';
    static staticVar = 'bar';

    constructor() {
        this.var1 = 'variable1';
        this.var2 = 'variable2';
    }

    static staticFunction() {
        alert('foo');
    }

    dynamicFunction() {
        alert('bar');
    }
    
}