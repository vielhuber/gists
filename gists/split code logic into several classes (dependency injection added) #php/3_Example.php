<?php
// src/App.php
namespace Example;

class Example
{
    private $test1;
    private $test2;
    private $test3;

    public function __construct(Test1 $test1 = null, Test2 $test2 = null, Test3 $test3 = null)
    {
        $this->test1 = $test1 ?: new Test1();
        $this->test2 = $test2 ?: new Test2();
        $this->test3 = $test3 ?: new Test3();
        $this->init();
    }

    public function init()
    {
        $this->test1->foo();
        $this->test2->bar();
        $this->test3->baz();
    }
}
