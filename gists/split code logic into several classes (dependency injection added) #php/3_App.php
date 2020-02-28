<?php
// src/App.php
namespace Example;

class App
{
    private $test1;
    private $test2;
    private $test3;
  	private $test4;

    public function __construct(Test1 $test1 = null, Test2 $test2 = null, Test3 $test3 = null, Test4 $test4 = null)
    {
        $this->test1 = $test1 ?: new Test1();
        $this->test2 = $test2 ?: new Test2();
        $this->test3 = $test3 ?: new Test3();
      	$this->test4 = $test4 ?: new Test4($this->test2, $this->test3); // only inject those classes that one depends on
        $this->init();
    }

    public function init()
    {
        $this->test1->foo();
        $this->test2->bar();
        $this->test3->baz();
      	$this->test4->gnarr();
    }
}
