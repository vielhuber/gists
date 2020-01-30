// old way
var Example = function(var1, var2)
{
  this.var1 = var1;
  this.var2 = var2;

  this.dynamicFunction = function()
  {
     var _this = this;
     alert(_this.var1+_this.var2);
  }
};

function test()
{
  var example = new Example(1,2);
  example.dynamicFunction(); // 3
}