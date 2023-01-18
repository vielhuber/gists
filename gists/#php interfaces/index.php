<?php
/* the interface does not contain code logic but only function declarations (and no variable declarations) */
interface InterfaceExample
{ 
  public function foo();
  public function bar($var); 
}
/* this class now has to implement those functions */
class ClassExample implements InterfaceExample
{ 
  public function foo()
  {
	echo 'foo';
  }
  public function bar($var)
  {
    echo 'bar'; 
  }
  /* this is also possible (functions can be added) */
  public function baz()
  {
   	echo 'baz'; 
  } 
}