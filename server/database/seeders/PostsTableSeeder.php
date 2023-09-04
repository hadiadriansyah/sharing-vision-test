<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->sentence(3),
                'content' => $faker->paragraph(2),
                'category' => 'Category ' . $faker->word,
                'status' => $faker->randomElement(['Publish', 'Draft', 'Trash']),

            ]);
        }
    }
}
