<?php

use App\UserState;
use Illuminate\Database\Seeder;

class UserStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserState::insert(
    		array(
    			['name' => 'Activo'],
    			['name' => 'Inactivo']
    		)
    	);
    }
}
