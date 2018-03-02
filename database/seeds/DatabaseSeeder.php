<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserInfoTableSeeder::class);
        $this->call(BookAuthorTableSeeder::class);
        $this->call(BookInfoTableSeeder::class);
    }
}
