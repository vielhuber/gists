<?php
namespace Example;

class ChildClass1 extends ParentClass
{ 
    public function __construct()
    {
        // prevents calling constructor of parent
    }
  	public function foo()
    {
      	echo $this::$var1;
      	echo $this::$var2;
    }
  	public function bar()
    {
     	echo '1'; 
    }
}