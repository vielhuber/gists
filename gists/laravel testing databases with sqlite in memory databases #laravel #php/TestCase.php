<?php
// tests/TestCase.php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

  	public function setUp()
    {
        parent::setUp();
    	/* do the migration and seeding on every test */
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

}