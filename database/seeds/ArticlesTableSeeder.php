<?php

use App\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article = new Article();
        $article->truncate();

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $article->create([
                'title' => $faker->realText(50),
                'description' => $faker->realText(100),
                'text' => $faker->realText(2000)
            ]);
        }
    }
}
