<?php


namespace App\Repositories;


use App\Contact;

class ContactRepositoryImpl extends GenericRepositoryImpl implements IContactRepository
{

    public function __construct()
    {
        $this-> model = new Contact();
    }

}
