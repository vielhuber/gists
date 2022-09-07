<?php
// tests/Test.php
namespace Example;
class Test extends \PHPUnit\Framework\TestCase
{
    protected $app;

    protected function setUp(): void
    {
        // basic (without mocking)
        //$this->app = new App();

        // advanced (with mocking)
        $test1 = $this->getMockBuilder(Test1::class)
            ->setConstructorArgs([])
            ->onlyMethods([])
            ->getMock();
        $test2 = $this->getMockBuilder(Test2::class)
            ->setConstructorArgs([])
            ->onlyMethods([])
            ->getMock();
        $test3 = $this->getMockBuilder(Test3::class)
            ->setConstructorArgs([])
            ->onlyMethods([])
            ->getMock();
        $test4 = $this->getMockBuilder(Test4::class)
            ->setConstructorArgs([])
            ->onlyMethods(['fun2'])
            ->getMock();
        /* overwrite function! */
        $test4
            ->expects($this->any())
            ->method('fun2')
            ->will(
                $this->returnCallback(function () {
                    return 1337;
                })
            );
        $this->app = $this->getMockBuilder(App::class)
            ->setConstructorArgs([$test1, $test2, $test3, $test4])
            ->onlyMethods([])
            ->getMock();
    }

    public function testSomeFunction()
    {
        $this->assertEquals($this->app->fun1(), 42);
        $this->assertEquals($this->app->fun2(), 1337); // this is mocked
    }
}
