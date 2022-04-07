<?php

namespace Database\Seeders;

use App\Models\Upcoming;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory;

class UpcomingSeeder extends Seeder
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
            Upcoming::create([
                'completed' => false,
                'title' => $faker->sentence($nbWords = 4, $variableWords = false),
                'approved' => false,
                'waiting' => true,
                'taskId' => Str::random(10)
            ]);
        }
    }
}
