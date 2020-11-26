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
                    throw new \Exception($url);
                })
            );
    }

    public function testRedirect()
    {
        try {
            $this->app->redirect('https://test.de');
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(), 'https://test.de');
        }
    }
}
