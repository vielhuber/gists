var Example = function()
{
  this.done = false;
  this.foo = function()
  {
     // we use "_this" here (not "self" or others)
     var _this = this;
     // function opens a new scope, we therefore have to reference _this
     window.setTimeout(function()
     {
     	_this.done = true;
     },1000);
     // alternative: es6
     window.setTimeout(() =>
     {
     	this.done = true;
     },1000);
  }
}
