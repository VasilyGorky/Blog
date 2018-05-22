<?php

use App\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->truncate();

        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('articles')->insert([
                'title' => $faker->realText(50),
                'description' => $faker->realText(100),
                'text' => $faker->realText(2000)
            ]);
        }
    }
}
