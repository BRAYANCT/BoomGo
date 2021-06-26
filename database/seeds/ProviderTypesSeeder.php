<?php

use App\ProviderType;
use Illuminate\Database\Seeder;

class ProviderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProviderType::insert(
            array(
                ['name' => 'Mayorista','question_registration'=>'¿Eres mayorista?'],
                ['name' => 'Exportador','question_registration'=>'¿Eres exportador?'],
                ['name' => 'Fabricante','question_registration'=>'¿Eres fabricante?'],
                ['name' => 'Importador','question_registration'=>'¿Eres Importador?'],
            )
        );
    }
}
