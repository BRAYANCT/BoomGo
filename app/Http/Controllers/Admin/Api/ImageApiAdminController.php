<?php

namespace App\Http\Controllers\Admin\Api;

use App\Image;
use App\Services\ImageServiceImpl;
use App\Utils\Services\ImageServiceImpl as ImageServiceUtilImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImageApiAdminController extends Controller
{
    private $service;
    private $imageServiceUtil;

    public function __construct()
    {
        $this->service = new ImageServiceImpl();
        $this-> imageServiceUtil = new ImageServiceUtilImpl();
    }


    /**
     * Sube la imagen del editor de texto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImageEditor(Request $request)
    {
        // Log::debug("api storeImageEditor");

        $data = array();

        $codeResponse = 200;

        try {
            $image = $request-> upload;
            $storage = config("constant.image.editor.storage");

            $imageName = $this-> imageServiceUtil
                -> saveInterventionImg($image,'',$storage,config("constant.image.quality"));

            $data['uploaded'] = 1;
            $data['fileName'] = $imageName;
            $data['url'] = route('admin.images.storage.show',['path'=>$storage,'imageName'=>$imageName]);

        } catch(\Exception $e){
            report($e);
            $data['error']['message'] = $e->getMessage();
            $codeResponse = 500;
        }

        return response()->json($data,$codeResponse);
    }


    /**
     * Sube la imagen del editor de texto al storage publico
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImageEditorPublic(Request $request)
    {
        // Log::debug("api storeImageEditor");

        $data = array();

        $codeResponse = 200;

        try {
            $image = $request-> upload;
            $storage = config("constant.image.editor.storage");

            $imageName = $this-> imageServiceUtil
                -> saveInterventionImg($image,'',config("constant.image.storage_public")."/".$storage,config("constant.image.quality"));

            $data['uploaded'] = 1;
            $data['fileName'] = $imageName;
            $data['url'] = route('images.storage.show',['path'=>$storage,'imageName'=>$imageName]);

        } catch(\Exception $e){
            report($e);
            $data['error']['message'] = $e->getMessage();
            $codeResponse = 500;
        }

        return response()->json($data,$codeResponse);
    }


    /**
     * Remueve la imagen el registro de la base de datos.
     *
     * @param  Image  $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Image $image)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $result = $this-> service-> delete($image);

            array_push ( $message , trans('crud.delete_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.delete_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Sube la imagen del editor de texto al storage publico
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFileInput(Request $request)
    {
        Log::debug("api storeFileInput");
        Log::debug($request->all());

        $data = array();
        $hasError = false;
        $codeResponse = 200;

        try {

            $imageConfig = config('constant.image');
            $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

            $rules = array(
                'image' => [
                    'required',
                    'image',
                    'mimes:'.$allowedExtensionsString,
                    'max:'.$imageConfig['max_size']
                ]
            );

            $validator = Validator::make($request -> all(),$rules);

            $hasError = $validator -> fails();

            if($hasError){
                $errors = $validator -> errors();

                $error= "";
                foreach( $errors->messages() as $index => $item){
                    foreach( $item as $index1 => $message){
                        $error .= $message;
                    }
                }
                $error .= "";
                $data['error'] = $error;

                Log::debug($error);

            }

//            $data['error'] = "Este es mi error";

//            $image = $request-> upload;
//            $storage = config("constant.image.editor.storage");




//            $imageName = $this-> imageServiceUtil
//                -> saveInterventionImg($image,'',config("constant.image.storage_public")."/".$storage,config("constant.image.quality"));

//            $data['uploaded'] = 1;
//            $data['fileName'] = $imageName;
//            $data['url'] = route('images.storage.show',['path'=>$storage,'imageName'=>$imageName]);

        } catch(\Exception $e){
            report($e);
            $data['error'] = $e->getMessage();
            $codeResponse = 500;
        }


        $data['hasError'] = $hasError;
        return response()->json($data,$codeResponse);
    }



}
