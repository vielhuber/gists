<?php
// if inside namespace
namespace Foo\Bar;
  
// this must be outside
require_once __DIR__ . '/vendor/autoload.php';
use Foo\Bar;
  
final class TestClass
{

   private $var0; // same as private $var0 = null;
   public $var = 'im a dynamic property';
   public static $var2 = 'im a static property';
   private $var3 = 'im a private property';
   public const VAR_4 = 'im a constant';
   $var = 'foo'; // same as public $var = 'foo'
      
   public function __construct() // must be public
   {
      echo __CLASS__.' was initiated';
     
     // you need variables to be defined on top(!)
     // in the past, you could also do
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
   
   // examples of static/non static
   public static function fnstat1() {
        echo self::$var2; // works
        //self::fndyn1(); // does not work
        //echo self::$var0; // does not work
   }
   public function fndyn1() {
        $this->fnstat1(); // works
        echo $this->var0; // works
     	TestClass::$var2; // works
        //echo $this->var2; // does not work
     	//echo self::fnstat1(); // does not work
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