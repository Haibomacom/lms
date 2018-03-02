<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\UserInfo::class, function (Faker\Generator $faker) {
    return [
        'openid'         => $faker->unique()->md5,
        'unionid'        => $faker->unique()->md5,
        'role'           => 1,
        'mobile'         => $faker->phoneNumber,
        'mobile_verify'  => $faker->numberBetween(0, 1),
        'password'       => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\BookAuthor::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->name;
    return [
        'name_cn' => $name,
        'name_en' => $name,
        'gender'  => $faker->numberBetween(0, 2),
        'intro'   => $faker->text,
    ];
});

$factory->define(\App\Models\BookInfo::class, function (Faker\Generator $faker) {
    return [
        'category_id'   => $faker->numberBetween(1, 2),
        'title'         => $faker->unique()->userName,
        'author_id'     => $faker->numberBetween(1, 10),
        'img'           => $faker->unique()->imageUrl(),
        'isbn'          => $faker->unique()->isbn13,
        'publish_house' => $faker->company,
        'publish_place' => $faker->address,
        'publish_time'  => $faker->year,
        'object'        => $faker->text(50),
        'intro'         => $faker->unique()->text,
        'douban'        => json_encode([]),
    ];
});