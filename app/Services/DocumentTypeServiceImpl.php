<?php


namespace App\Services;


use App\Repositories\DocumentTypeRepositoryImpl;

class DocumentTypeServiceImpl extends GenericServiceImpl implements IDocumentTypeService
{

    public function __construct()
    {
        $this-> repository = new DocumentTypeRepositoryImpl();
    }

}
