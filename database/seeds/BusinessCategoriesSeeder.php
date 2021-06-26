<?php

use App\Category;
use Illuminate\Database\Seeder;

class BusinessCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = config('constant.category.business_categories');

        foreach($categories as $category){

            $category = Category::create([
                'category_type_id' => config('constant.categorytype.business_id'),
                'name' => $category['name'],
                'slug' => $category['slug'],
            ]);

            $category->code = $category->id;
            $category->save();

        }
    }
}
