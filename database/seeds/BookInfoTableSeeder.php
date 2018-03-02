<?php

use Illuminate\Database\Seeder;

class BookInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\BookInfo::class, 20)->create();
    }
}
