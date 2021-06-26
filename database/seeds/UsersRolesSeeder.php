<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

      	$users->each(function ($user, $key) {
	        // si no tiene roles se le asigna de forma aleatoria
	        if(count($user-> roles)<=0){	          
	          $rolesRandom = Role::all()->random();
	          $user -> syncRoles($rolesRandom-> id);
	        }

      	});
    }
}
