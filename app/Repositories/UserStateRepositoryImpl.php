<?php 
namespace App\Repositories;

use App\Repositories\GenericRepositoryImpl;
use App\Repositories\IUserStateRepository;
use App\UserState;

class UserStateRepositoryImpl extends GenericRepositoryImpl implements IUserStateRepository
{

    public function __construct()
    {
        $this-> model = new UserState();
    }


}
?>