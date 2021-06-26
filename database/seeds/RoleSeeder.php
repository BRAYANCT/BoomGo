<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            [
                'name' => config('constant.role.ADMIN_SYS'),
                'guard_name'=>'web',
            ],
            [
                'name' => config('constant.role.ADMIN'),
                'guard_name'=>'web',
            ],
            [
              'name' => config('constant.role.VENDOR'),
              'guard_name'=>'web',
            ],
            [
                'name' => config('constant.role.CUSTOMER'),
                'guard_name'=>'web',
            ],

        );

       	$this-> createRolesIfNotExist($roles);
    }


    /**
    * Crea los roles
    * @param Array $roles
    *
    */
    public function createRolesIfNotExist($roles){

    	foreach ($roles as $index => $item) {

  			$role = Role::where('name', $item['name'])
  						->where('guard_name', $item['guard_name'])
  						-> first();

  			if($role == null){
  				$role = Role::create(['name' => $item['name'],'guard_name'=>$item['guard_name']]);
  			}

    	}
    }
}
