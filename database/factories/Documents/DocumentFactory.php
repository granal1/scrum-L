<?php

namespace Database\Factories\Documents;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documents\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'id' => fake()->uuid(),
            'incoming_at' => fake()->dateTimeBetween('2019-01-01', '2023-12-31'),
            'short_description' => fake()->realTextBetween(10, 50),
            'content' => fake()->realTextBetween(50, 2000),
            'created_at' => now(),
            'path' => fake()->realText(45),
            'author_uuid' => User::inRandomOrder()->first()->id,
        ];
    }
}
