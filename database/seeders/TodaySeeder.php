<?php

namespace Database\Seeders;

use App\Models\Today;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory;

class TodaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Today::create([
                'completed' => false,
                'title' => $faker->sentence($nbWords = 4, $variableWords = false),
                'approved' => false,
                'taskId' => Str::random(10)
            ]);
        }
    }
}
