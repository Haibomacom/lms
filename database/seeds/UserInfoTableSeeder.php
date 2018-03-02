<?php

use Illuminate\Database\Seeder;

class UserInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\UserInfo::class, 10)->create();
    }
}
