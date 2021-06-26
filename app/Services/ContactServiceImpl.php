<?php


namespace App\Services;


use App\Repositories\ContactRepositoryImpl;

class ContactServiceImpl extends GenericServiceImpl implements IContactService
{

    public function __construct()
    {
        $this-> repository = new ContactRepositoryImpl();
    }

}
