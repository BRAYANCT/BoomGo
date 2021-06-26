<?php

namespace App\Http\Controllers\Web\Api;

use App\Business;
use App\Http\Requests\Web\ReviewFormForAuthUserRequest;
use App\Http\Resources\Web\ReviewWebResource;
use App\Review;
use App\Services\ReviewServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewApiWebController extends Controller
{
    private $service;

    public function __construct()
    {
        $this-> service = new ReviewServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }


    /**
     * Registra un review del usuario autenticado para el negocio.
     *
     * @param Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeByBusinessForAuthUser(Business $business,ReviewFormForAuthUserRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $validated = $request->validated();
            $authUser = Auth::user();
            $validated['user_id'] = $authUser->id;

            $model = $this-> service-> createByBusiness($business,$validated);

            $data['model'] = new ReviewWebResource($model);
            array_push ( $message , trans('crud.review.store_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.review.store_error'));
            $codeResponse = 500;
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Obtiene el listado de los ultimos comentario
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBusinessLatest(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $parameters = array(
                ['model_type',Business::class],
                ['orderBy','created_at','desc'],
                ['whereHasMorph','reviewable',Business::class],
                ['has','user'],
            );

            $limit = 5;
            if($request->filled('limit')){
                $limit = $request->input('limit');
            }

            array_push($parameters,['limit',$limit]);

            $relationshipNames = array('user','reviewable');
            $list = ReviewWebResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
            array_push ( $message , trans('crud.list_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.list_error'));
            $codeResponse = $e->getCode();
        }

        $data['list'] = $list;
        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessReviews(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{

//            \Log::debug($request->all());

            $parameters = array(
                ['model_type','=',Business::class]
            );
            $relationshipNames = array('reviewable','user');

            $quantity = 5;
            if($request->filled('quantity')){
                $quantity = $request->input('quantity');
            }
            array_push($parameters,['limit',$quantity]);

            if($request->filled('business_id')){
                array_push($parameters,['model_id','=',$request->input('business_id')]);
            }

            if($request->filled('last')){
                array_push($parameters,['orderBy','created_at','desc']);
            }

//            \Log::debug($parameters);

            $list = ReviewWebResource::collection($this-> service-> findAllWhere($parameters,$relationshipNames));

            array_push ( $message , trans('crud.list_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.list_error'));
            $codeResponse = $e->getCode();
        }

        $data['list'] = $list;
        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}
