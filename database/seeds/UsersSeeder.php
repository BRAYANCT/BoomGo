<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               // crea el usuario administrador del sistema
    	$usuarioDanilo = User::where('username','dperalta')->first();
    	if(!$usuarioDanilo){
    		$usuarioDanilo = new User();
	    	$usuarioDanilo-> names = 'Fabricio Danilo';
	    	$usuarioDanilo-> surnames = 'Peralta Bendezu';
	    	$usuarioDanilo-> email = 'danilo_peralta4@hotmail.com';
	    	$usuarioDanilo-> username = 'dperalta';
	    	$usuarioDanilo-> password = bcrypt("123456");
	    	$usuarioDanilo-> api_token = Str::random(60);
	    	$usuarioDanilo-> remember_token = Str::random(60);
	    	$usuarioDanilo-> save();

		    $usuarioDanilo -> syncRoles(config('constant.role.ADMIN_SYS'));

    	}

        // crea el usuario administrador del sistema
        $usuario2 = User::where('username','fcordova')->first();
        if(!$usuario2){
            $usuario2 = new User();
            $usuario2-> names = 'Freddy Cordova';
            $usuario2-> surnames = '';
            $usuario2-> email = 'fcordova@gmail.com';
            $usuario2-> username = 'fcordova';
            $usuario2-> password = bcrypt("123456");
            $usuario2-> api_token = Str::random(60);
            $usuario2-> remember_token = Str::random(60);
            $usuario2-> save();

            $usuario2 -> assignRole(config('constant.role.ADMIN'));
        }

        // crea el usuario administrador del sistema
        $roy = User::where('username','roy')->first();
        if(!$roy){
            $roy = new User();
            $roy-> names = 'Roy';
            $roy-> surnames = 'Condori';
            $roy-> email = 'roy@micorreo.com';
            $roy-> username = 'roy';
            $roy-> password = bcrypt("123456");
            $roy-> api_token = Str::random(60);
            $roy-> remember_token = Str::random(60);
            $roy-> save();

            $roy -> assignRole(config('constant.role.ADMIN'));
        }

    }
}
