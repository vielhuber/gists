<?php
class Test extends \PHPUnit\Framework\TestCase
{
  
  	protected $var;
  
  	// runs before every single test
  	protected function setUp(): void
    {
    }
  
  	// runs before all tests
    public static function setUpBeforeClass(): void
    {
    }
  
  	// runs after every single test
  	protected function tearDown(): void
    {
    }
  
  	// runs after all tests
  	public static function tearDownAfterClass(): void
    {
      
    }
  
  	// functions that start with the keyword "test" in the name run sequentially
    public function testSomeFunction()
    {
      
        $this->assertTrue(true);
      	$this->assertEquals('1',1); // passes
        $this->assertSame('1',1); // fails
        $this->assertEquals((object)['foo'],(object)['foo']); // passes
		$this->assertSame((object)['foo'],(object)['foo']); // fails
      	$this->assertContains('foo',['foo','bar']); // passes
      
      	// live log to console while running
      	fwrite(STDERR, print_r('foo'.PHP_EOL, true));
      
      	// run test n times
      	for($test_iteration = 0; $test_iteration < 10; $test_iteration++)
        {
         	 // your test code
        }
      
    }
  
}