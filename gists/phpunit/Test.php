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
  	// always use snake case and "test_that_..."
    public function test_that_something_works()
    {
      	// general rule: the expected value should come first as an argument      
      
        $this->assertTrue(true);
      	$this->assertEquals('1',1); // passes
        $this->assertSame('1',1); // fails
        $this->assertEquals((object)['foo'],(object)['foo']); // passes
		$this->assertSame((object)['foo'],(object)['foo']); // fails
      	$this->assertContains('foo',['foo','bar']); // passes
        $this->assertStringContainsString('foo', 'foobar'); // passes
      	$this->assertMatchesRegularExpression('/foo/', 'foobar'); // passes
        $this->assertMatchesRegularExpression('/foo/i', 'FoObar'); // passes
        $response = 'foobar'; $this->assertThat(
            $response,
            $this->logicalOr(
                $this->stringContains('foo', $response),
                $this->stringContains('baz', $response)
            )
        );
        $this->assertCount(10, 1+2+3+4);
        
      	// assert with fail message (helpful for debugging)
      	$this->assertTrue(false, 'some additional information');
      
      	// live log to console while running
      	fwrite(STDERR, print_r('foo'.PHP_EOL, true));
      
        // test exceptions
        $this->expectException(Throwable::class);
      	throw new \Exception('foo');
      
      	// run test n times and with time limit
      	$previous_time_limit = ini_get('max_execution_time');
      	set_time_limit(5); // note: @large etc. are not working
      	for($test_iteration = 0; $test_iteration < 10; $test_iteration++) {
         	 // your test code
        }
      	set_time_limit($previous_time_limit);      	
      
    }
  
}