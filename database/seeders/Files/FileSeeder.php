<?php

namespace Database\Seeders\Files;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Uuid\Uuid;


class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 20000; $x++)
        {
            DB::table('files')->insert($this->getData());
        }

    }

    public function getData()
    {
       // $faker = \Faker\Factory::create('ru_RU');
        return [
            'id' => fake()->uuid(),
            'incoming_at' => fake()->dateTimeBetween('2023-01-01', '2023-12-31'),
            'short_description' => fake()->realTextBetween(10, 50),
            'content' => fake()->realTextBetween(13100, 14660),
            'created_at' => now(),
            'path' => fake()->realText(45),
            'author_uuid' => User::inRandomOrder()->first()->id,
        ];
    }
}
