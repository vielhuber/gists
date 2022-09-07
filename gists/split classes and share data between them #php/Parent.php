<?php
namespace Example;
require_once __DIR__ . '/../../vendor/autoload.php';

class ParentClass
{
  	// this is what static variables are for: shared across classes
 	public static $var1 = null;
	public static $var2 = null;
	public $var3 = null;  
  
    public function __construct()
    {
        $this->initCommonVars();
        $this->initIndividualVars();
      	$this->exampleMethod();
    }
  	// convenience method
    public function __get($class)
    {
        $class = '\\Example\\' . $class;
        return new $class();
    }
  	public function initCommonVars()
    {
      	$this::$var1 = 'foo';
      	$this::$var2 = 'bar';
    }  
  	public function initIndividualVars()
    {
      	$this->var3 = 'baz';
    }
    public function exampleMethod()
    {
		$this->ChildClass1->foo();
      	$this->ChildClass2->foo();
    }
  
}

$x = new ParentClass(); // foobarfoobar