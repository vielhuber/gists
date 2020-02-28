<?php
// src/Test4.php
namespace Example;

class Test4
{
  	public $test2;
  	public $test3;
  
    function __construct(Test2 $test2 = null, Test3 $test3 = null)
    {
        $this->test2 = $test2 ?: new Test2();
      	$this->test3 = $test3 ?: new Test3();
    }
  
    public function gnarr()
    {
        echo $this->test2->bar().'baz'.$this->test3->baz();
    }
}
