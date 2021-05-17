import Store from './Store';
import Example from './Example';

export default class App
{

    constructor()
    {
        Store.data.foo = 'bar';
        alert(Store.data.foo);
        Example.fun();
    }
    
}