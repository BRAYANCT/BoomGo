<?php

use App\PriceRange;
use Illuminate\Database\Seeder;

class PriceRangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceRange::insert(
            array(
                ['name' => 'Barato','symbol'=>'$'],
                ['name' => 'Moderado','symbol'=>'$$'],
                ['name' => 'Caro','symbol'=>'$$$'],
            )
        );
    }
}
