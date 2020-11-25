<?php
// tests/Test.php
namespace Example;

class Test extends \PHPUnit\Framework\TestCase
{
    protected $app;

    protected function setUp(): void
    {
        $this->app = $this->getMockBuilder(App::class)
            ->setConstructorArgs([])
            ->onlyMethods(['redirect'])
            ->getMock();
        $this->app
            ->expects($this->any())
            ->method('redirect')
            ->will(
                $this->returnCallback(function ($url) {
                    header('Location: ' . $url, true, 302);
                    // here we don't use "die()" as in the original code
                })
            );
    }

    /**
     * @runInSeparateProcess
     **/
    public function testRedirect()
    {
        $this->app->redirect('https://test.de');
        $this->assertContains('Location: https://test.de', xdebug_get_headers());
    }
}
