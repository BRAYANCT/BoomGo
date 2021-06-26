<?php


namespace App\Repositories;


use App\Transaction;

class TransactionRepositoryImpl extends GenericRepositoryImpl implements ITransactionRepository
{

    public function __construct()
    {
        $this-> model = new Transaction();
    }

}
