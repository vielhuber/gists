<?php
class TestClass
{

   public $var = 'im a dynamic property';
   public static $var2 = 'im a static property';
      
   public function __construct()
   {
      echo __CLASS__.' was initiated';
   }
   
   public function dynFunction($arg)
   {
     	$this->thisIsAPublicFunction();
   		self::statFunction();
   }
   
   public static function statFunction($arg)
   {
   
   }
  
   function thisIsAPublicFunction()
   {
    	// omitting the keyword means "public" 
   }

}

// static function from class
TestClass::statFunction('foo');
// static property from class
echo TestClass::$var2;

$obj = new TestClass();
// dynamic function from object
$obj->dynFunction('foo');
// dynamic property from object
echo $obj->var;
// static property from object
echo $obj::$var2;