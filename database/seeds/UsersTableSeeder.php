<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.ru',
            'password' => '$2y$10$6RlTynG4iQb7W4aRyckPqezQO2x61i11e9vMHRV03G3RviLMYfoOK', //password: admin123
            'verified' => '1'
        ]);
    }
}
