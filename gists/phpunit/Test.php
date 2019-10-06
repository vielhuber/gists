<?php
class Test extends \PHPUnit\Framework\TestCase
{
  
  	protected $var;
  
  	// runs before every single test
  	protected function setUp()
    {
    }
  
  	// runs before all tests
    public static function setUpBeforeClass()
    {
    }
  
  	// runs after every single test
  	protected function tearDown()
    {
    }
  
  	// runs after all tests
  	public static function tearDownAfterClass()
    {
      
    }
  
    public function test123()
    {
      
        $this->assertTrue(true);
      	$this->assertEquals('1',1); // passes
        $this->assertSame('1',1); // fails
        $this->assertEquals((object)['foo'],(object)['foo']); // passes
		$this->assertSame((object)['foo'],(object)['foo']); // fails
      
      	// live log to console while running
      	fwrite(STDERR, print_r('foo'.PHP_EOL, true));
      
      	// run test n times
      	for($test_iteration = 0; $test_iteration < 10; $test_iteration++)
        {
         	 // your test code
        }
      
    }
  
}