<?php


namespace App\Repositories;


use App\Review;

class ReviewRepositoryImpl extends GenericRepositoryImpl implements IReviewRepository
{

    public function __construct()
    {
        $this-> model = new Review();
    }

}
