<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Utils\Services\ImageServiceImpl;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {


	$imageService = new ImageServiceImpl();

    $names = $faker-> firstName;
    $surnames = $faker-> lastName;


    $storage = config("constant.image.user.storage");

    $image_name = $imageService->saveAvatarImage($names.$surnames,$storage);


    return [
        'names' => $names,
        'surnames' => $surnames,
        'email' => $faker->unique()->safeEmail,
        'username'=> $faker->unique()->username,
        'profile_picture'=> $image_name,
        'password' => bcrypt("123456"),
        'api_token' => Str::random(60),
        'remember_token' => Str::random(10),
    ];


});
