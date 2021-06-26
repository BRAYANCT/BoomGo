<?php

use App\CategoryType;
use Illuminate\Database\Seeder;

class CategoryTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryType::insert(
            array(
                ['id' => config('constant.categorytype.business_id'),'name' => 'Negocio','slug'=> config('constant.categorytype.business_slug')],
                ['id' => config('constant.categorytype.product_id'),'name' => 'Producto','slug'=> config('constant.categorytype.product_slug')]
            )
        );
    }
}
