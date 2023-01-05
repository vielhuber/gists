<?php
namespace Example;

class ChildClass2 extends ParentClass
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
      	// you can even call the other child!
     	echo $this->ChildClass1->bar();
    }
}