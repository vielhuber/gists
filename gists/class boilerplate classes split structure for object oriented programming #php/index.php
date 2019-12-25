<?php
class TestClass
{

   private $var0; // same as private $var0 = null;
   public $var = 'im a dynamic property';
   public static $var2 = 'im a static property';
   private $var3 = 'im a private property';
      
   public function __construct()
   {
      echo __CLASS__.' was initiated';
     
     // you don't need variables to be defined on top, but it's "good style"
     // but you can also do:
     $this->var4 = 'foo'; // this is the same as public $var4 = 'foo'
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
  
   private function thisIsAPrivateFunction()
   {
     
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