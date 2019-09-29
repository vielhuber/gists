<?php
/* traits are a way of sharing code between classes without class inheritance */
/* always use traits if you want to share code (e.g. functions) between different classes */
/* that are not connected in a reasonable way through class inheritance */
trait TraitExample
{
    public $foo = 1337;
    public function foo()
    {
        echo 'foo';
    }
}

class ClassExample
{
    use TraitExample;
    public function bar()
    {
        echo 'bar';
    }
}
$class = new ClassExample();
echo $class->foo; // 1337
$class->foo(); // foo
$class->bar(); // bar

/* an alternative way is with class inheritance */
/* the problem is that you can only inherit from one class and the structure is often not natural */
class ParentExample2
{
    public $foo = 1337;
    public function foo()
    {
        echo 'foo';
    }
}
class ClassExample2 extends ParentExample2
{
    public function bar()
    {
        echo 'bar';
    }
}
$class = new ClassExample2();
echo $class->foo; // 1337
$class->foo(); // foo
$class->bar(); // bar