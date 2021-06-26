<?php


namespace App\Services;


use App\Business;
use App\Repositories\ReviewRepositoryImpl;
use App\Review;

class ReviewServiceImpl extends GenericServiceImpl implements IReviewService
{

    public function __construct()
    {
        $this-> repository = new ReviewRepositoryImpl();
    }


    /**
     *
     * Guarda un registro para el negocio
     *
     * @param Business $business
     * @param array $data
     * @return Review::class
     */
    public function createByBusiness(Business $business,$data)
    {
        \DB::beginTransaction();
        $review = null;
        try {

            $data['model_id'] = $business->id;
            $data['model_type'] = Business::class;

            //guarda el review
            $review = $this-> repository-> create($data);

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }

        return $review;
    }

}
