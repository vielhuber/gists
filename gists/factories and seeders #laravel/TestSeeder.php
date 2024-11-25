<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
       	// single
      	$model = House::factory()->create([
          'foo' => 'bar',
          'bar' => 'baz'
        ]);
      
      	// multiple
        House::factory()
            ->count(10)
            ->create([
              'foo' => 'bar',
              'bar' => 'baz'
        	]);
      
      	// different values
        House::factory()
          ->count(3)
        	->state(new Sequence(
            	['foo' => 'value1'],
            	['foo' => 'value2'],
            	['foo' => 'value3'],
        	))
        	->create();
          
        // 1:n        
        $model = House::factory()->has(
          Window::factory()
          	->has(/*...*/) // nested
            ->for(/*...*/) // nested
          	->state([
	            'foo' => 'bar',
	            'bar' => 'baz'
	          ]),
          'windows'
        )
        ->create([
          'foo' => 'bar',
          'bar' => 'baz'
        ]);
          
        // n:1
        $model = House::factory()->for(
          Window::factory()
          	->has(/*...*/) // nested
            ->for(/*...*/) // nested
          	->state([
	            'foo' => 'bar',
	            'bar' => 'baz'
	          ]),
          'window'
        )
        ->create([
          'foo' => 'bar',
          'bar' => 'baz'
        ]);
    }
}
