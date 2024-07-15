<?php

namespace Database\Factories;

use App\Models\X;
use App\Models\Y;
use App\Models\Z;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'foo' => fake()->unique()->regexify('[0-9][0-9][0-9][0-9][0-9][\-][0-9][0-9]'),
            'bar' => fake()->optional()->realText(200),
            'x_id' => X::factory(), // this is how to handle relationships
            'y_id' => Y::factory(),
            'z_id' => Z::factory(),
        ];
    }
}
