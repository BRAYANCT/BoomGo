<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{


    public function getDisplayNameAttribute(){
    	$name = $this -> name;

    	if($this->isAdminSys()){
			return config('constant.role.ADMIN_SYS_TEXT');
		}else if($this->isAdmin()){
			return config('constant.role.ADMIN_TEXT');
		}else if($this->isVendor()){
            return config('constant.role.VENDOR_TEXT');
        }else if($this->isCustomer()){
            return config('constant.role.CUSTOMER_TEXT');
        }
        return 'Ninguno' ;
    }


    /**
     * Verifica si el role es administrador del sistema
     *
     * @param
     * @return boolean
     */
    public function isAdminSys()
    {
        return $this -> name == config('constant.role.ADMIN_SYS');
    }

    /**
     * Verifica si el role es administrador
     *
     * @param
     * @return boolean
     */
    public function isAdmin()
    {
        return $this -> name == config('constant.role.ADMIN');
    }

    /**
     * Verifica si el role es vendedor
     *
     * @param
     * @return boolean
     */
    public function isVendor()
    {
        return $this -> name == config('constant.role.VENDOR');
    }

    /**
     * Verifica si el role es cliente
     *
     * @param
     * @return boolean
     */
    public function isCustomer()
    {
        return $this -> name == config('constant.role.CUSTOMER');
    }

    /**
     * Verifica si el rol puede elegir un negocio
     *
     * @return Boolean
     */
    public function canChooseBusiness()
    {
        return $this->isAdminSys() || $this->isAdmin();
    }

}
