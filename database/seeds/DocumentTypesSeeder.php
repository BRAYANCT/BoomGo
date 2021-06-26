<?php

use App\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::insert(
            array(

                ['name' => 'DNI'],
                ['name' => 'CE'],
            )

        );
    }
}
