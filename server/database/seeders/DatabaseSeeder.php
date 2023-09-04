<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->sentence(3),
                'content' => $faker->paragraph(2),
                'category' => 'Category ' . $faker->word,
                'status' => $faker->randomElement(['Publish', 'Draft', 'Trash']),

            ]);
        }


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
