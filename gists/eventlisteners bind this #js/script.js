document.querySelector('.foo').addEventListener(fun);          	
// if you need arguments etc.
document.querySelector('.foo').addEventListener(() => { fun(); });
// if you need to bind this to current object
document.querySelector('.foo').addEventListener(fun.bind(this));
// if you need to remove in the future an event, that was binded, save it beforehand inside a variable
this.funBind = fun.bind(this);
document.querySelector('.foo').addEventListener(this.funBind);
document.querySelector('.foo').removeEventListener(this.funBind);