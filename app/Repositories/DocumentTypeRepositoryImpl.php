<?php


namespace App\Repositories;


use App\DocumentType;

class DocumentTypeRepositoryImpl extends GenericRepositoryImpl implements IDocumentTypeRepository
{

    public function __construct()
    {
        $this-> model = new DocumentType();
    }

}
