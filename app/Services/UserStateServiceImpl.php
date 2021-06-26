<?php 
namespace App\Services; 

use App\Repositories\UserStateRepositoryImpl;
use App\Services\GenericServiceImpl;
use App\Services\IUserStateService;

class UserStateServiceImpl extends GenericServiceImpl implements IUserStateService{

 	public function __construct()
    {		
    	$this-> repository = new UserStateRepositoryImpl();
    }

}
?>