<?php

use App\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$adminSys = config('constant.role.ADMIN_SYS');
    	$admin = config('constant.role.ADMIN');
        $vendor = config('constant.role.VENDOR');
        $customer = config('constant.role.CUSTOMER');

    	$all = [$adminSys,$admin,$vendor,$customer];

    	$adminSysAndAdmin = [$adminSys,$admin];


        $permissions = array(
        //*******************************************************************************//
        //********************************* Users ***************************************//
        //*******************************************************************************//

            [
              'name' => 'admin_users_profile_edit',
              'guard_name'=>'web',
              'roles'=>$all
            ],
            [
              'name' => 'admin_users_profile_update',
              'guard_name'=>'web',
              'roles'=>$all
            ],

            [
                'name' => 'admin_users_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
              'name' => 'admin_users_create',
                'guard_name'=>'web',
              'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_users_store',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_users_edit',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_users_update',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_users_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'api_admin_users_list_table_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_users_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'api_admin_users_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_users_destroy_by_ids',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
        //**********************************************************************************//
        //*********************************  fin de users **********************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Images **************************************//
        //*******************************************************************************//

            [
              'name' => 'admin_images_storage_show',
              'guard_name'=>'web',
              'roles'=>$all
            ],
            [
              'name' => 'admin_images_fit_show',
              'guard_name'=>'web',
              'roles'=>$all
            ],
            [
              'name' => 'admin_images_resize_show',
              'guard_name'=>'web',
              'roles'=>$all
            ],

        //**********************************************************************************//
        //*********************************  Fin de Images *********************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Businesses **********************************//
        //*******************************************************************************//


            [
                'name' => 'admin_businesses_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_businesses_create',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_businesses_store',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_businesses_edit',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_businesses_update',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_businesses_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'businesses_admin_businesses_profile_create_edit',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer],
            ],

            [
                'name' => 'businesses_admin_businesses_profile_store_update',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer],
            ],

            [
                'name' => 'api_admin_businesses_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_businesses_list_table_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_businesses_store',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_businesses_profile_store_update',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'api_admin_businesses_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'admin_businesses_update',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],
            [
                'name' => 'api_admin_businesses_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'api_admin_businesses_destroy_by_ids',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
        //**********************************************************************************//
        //*********************************  Fin de Businesses *****************************//
        //**********************************************************************************//


        //*******************************************************************************//
        //********************************* Products ************************************//
        //*******************************************************************************//


            [
                'name' => 'admin_products_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_products_create',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],
            [
                'name' => 'admin_products_edit',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'businesses_admin_products_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor],
            ],

            [
                'name' => 'businesses_admin_products_create',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor],
            ],

            [
                'name' => 'businesses_admin_products_edit',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor],
            ],

            [
                'name' => 'api_admin_products_store',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor],
            ],

            [
                'name' => 'api_admin_products_show',
                'guard_name'=>'web',
                'roles'=>[$admin,$adminSys,$vendor],
            ],

            [
                'name' => 'admin_products_update',
                'guard_name'=>'web',
                'roles'=>[$admin,$adminSys,$vendor],
            ],

            [
                'name' => 'api_admin_products_destroy',
                'guard_name'=>'web',
                'roles'=>[$admin,$adminSys,$vendor],
            ],

            [
                'name' => 'api_admin_products_destroy_by_ids',
                'guard_name'=>'web',
                'roles'=>[$admin,$adminSys,$vendor],
            ],

        //**********************************************************************************//
        //*********************************  Fin de Products *******************************//
        //**********************************************************************************//


        //*******************************************************************************//
        //********************************* Categories **********************************//
        //*******************************************************************************//

            [
                'name' => 'admin_categories_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'admin_categories_create',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'admin_categories_store',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'admin_categories_edit',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'admin_categories_update',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'admin_categories_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'api_admin_products_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_categories_products',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_categories_businesses',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

            [
                'name' => 'api_admin_categories_list_table_index',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'api_admin_categories_destroy',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

            [
                'name' => 'api_admin_categories_destroy_by_ids',
                'guard_name'=>'web',
                'roles'=>$adminSysAndAdmin
            ],

        //**********************************************************************************//
        //*********************************  Fin de Categories *****************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Images **************************************//
        //*******************************************************************************//
            [
                'name' => 'api_admin_images_store_editor_public',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_images_destroy',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Images *********************************//
        //**********************************************************************************//


        //*******************************************************************************//
        //********************************* Shippings ***********************************//
        //*******************************************************************************//

            [
                'name' => 'admin_shipping_form_list_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_shipping_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_shipping_store',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'admin_shipping_update',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_shipping_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_shipping_destroy',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_shipping_destroy_by_ids',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Shippings ******************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Departments *********************************//
        //*******************************************************************************//

            [
                'name' => 'api_admin_departments_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Departments ****************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Provinces ***********************************//
        //*******************************************************************************//

            [
                'name' => 'api_admin_provinces_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Provinces ******************************//
        //**********************************************************************************//

        //*******************************************************************************//
        //********************************* Districts ***********************************//
        //*******************************************************************************//

            [
                'name' => 'api_admin_districts_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Districts ******************************//
        //**********************************************************************************//

        //*********************************************************************************//
        //********************************* Price ranges **********************************//
        //*********************************************************************************//

            [
                'name' => 'api_admin_price_ranges_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Price ranges ***************************//
        //**********************************************************************************//

        //*********************************************************************************//
        //********************************* Provider Types ********************************//
        //*********************************************************************************//

            [
                'name' => 'api_admin_provider_types_ranges_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Provider Types *************************//
        //**********************************************************************************//


        //*********************************************************************************//
        //********************************* Business Payment Method ***********************//
        //*********************************************************************************//

            [
                'name' => 'admin_business_payment_method_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],
            [
                'name' => 'api_admin_business_payment_method_businesses_mercado_pago',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_business_payment_method_businesses_wire_transfer',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_business_payment_method_businesses_wire_transfer_store_update',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'businesses_admin_business_payment_method_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

            [
                'name' => 'api_admin_business_payment_method_businesses_wire_transfer_store',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Business Payment Method ****************//
        //**********************************************************************************//

        //*********************************************************************************//
        //********************************* Orders ****************************************//
        //*********************************************************************************//

            [
                'name' => 'admin_orders_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],
            [
                'name' => 'admin_orders_menu_auth_user_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'admin_orders_auth_user_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'businesses_admin_orders_auth_user_business_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'admin_orders_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'admin_orders_auth_user_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'businesses_admin_orders_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_orders_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],
            [
                'name' => 'api_admin_orders_business_auth_user_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor]
            ],
            [
                'name' => 'api_admin_orders_auth_user_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'api_admin_orders_change_to_paid_out',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'api_admin_orders_change_to_delivered',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],
            [
                'name' => 'api_admin_orders_change_to_cancelled',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin,$vendor,$customer]
            ],


        //**********************************************************************************//
        //*********************************  Fin de Orders  ********************************//
        //**********************************************************************************//


        //*********************************************************************************//
        //********************************* Claims ****************************************//
        //*********************************************************************************//

            [
                'name' => 'admin_claims_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

            [
                'name' => 'admin_claims_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

            [
                'name' => 'api_admin_claims_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Claims *********************************//
        //**********************************************************************************//


        //*********************************************************************************//
        //********************************* Contacts **************************************//
        //*********************************************************************************//

            [
                'name' => 'admin_contacts_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

            [
                'name' => 'admin_contacts_show',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

            [
                'name' => 'api_admin_contacts_list_table_index',
                'guard_name'=>'web',
                'roles'=>[$adminSys,$admin]
            ],

        //**********************************************************************************//
        //*********************************  Fin de Contacts *******************************//
        //**********************************************************************************//

//        //*********************************************************************************//
//        //********************************* Orders Group **********************************//
//        //*********************************************************************************//
//
//            [
//                'name' => 'admin_order_groups_auth_user_index',
//                'guard_name'=>'web',
//                'roles'=>[$adminSys,$admin,$vendor,$customer]
//            ],
//
//        //**********************************************************************************//
//        //******************************  Fin de Orders Group  *****************************//
//        //**********************************************************************************//

        );

    	$this->createRolesPermissions($permissions);
    }





    /**
    * Crea los permisos de los roles
    * @param array $permissions
    *
    */
    public function createRolesPermissions($permissions)
    {

    	foreach ($permissions as $index => $item) {

    		// Verifica si existe el permiso o si no lo crea
    		$permission = Permission::where('name', $item['name'])
    								->where('guard_name', $item['guard_name'])
									-> first();
			if($permission == null){
  				$permission = Permission::create(['name' => $item['name'],'guard_name'=>$item['guard_name']]);
  			}

			if(isset($item['roles'])){
				// asigna el permiso a los roles
				$roles = $item['roles'];

				foreach ($roles as $key => $codeRole) {

	    			$role = Role::where('name', $codeRole)
	  						->where('guard_name', $permission-> guard_name)
	  						-> first();

	  				if($role != null){
	  					if(!$role -> hasPermissionTo($permission-> name)){
	  						$role -> givePermissionTo($permission-> name);
	  					}
	  				}

	    		}
			}
    	}
    }

    
}
