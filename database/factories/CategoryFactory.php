<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\CategoryType;
use App\Helpers\UrlHelper;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $categoryType = CategoryType::all()->random();

    $name = $faker-> sentence(2);

    $slug = UrlHelper::generateUniqueSlug(new Category(),$name,['category_type_id'=>$categoryType->id]);

    return [
        'category_type_id'=> $categoryType-> id,
        'name' => $name,
        'slug' => $slug,
    ];
});
