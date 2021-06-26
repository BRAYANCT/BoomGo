<?php


namespace App\Services;


use App\Repositories\TransactionRepositoryImpl;

class TransactionServiceImpl extends GenericServiceImpl implements ITransactionService
{

    public function __construct()
    {
        $this-> repository = new TransactionRepositoryImpl();
    }

}
