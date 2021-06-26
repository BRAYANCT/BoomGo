<?php

namespace App\Http\Controllers\Web\Api;

use App\Contact;
use App\Http\Requests\Web\ContactStoreWebRequest;
use App\Mail\Contact\NewContactMail;
use App\Services\ContactServiceImpl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ContactServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContactStoreWebRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $contact = $this-> service-> create($request->validated());
            $data['model'] = $contact;

            array_push ( $message , trans('crud.contact.store_success'));
            $hasError = false;

        }catch(\Exception $e){
            report($e);
            // array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.contact.store_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        // si no tiene errores envia el correo
        if(!$hasError){
            try {
                $when = Carbon::now()->addSeconds(10);

                $emailTo = config('app.email_admin');

                if(config('app.mail_debug')){
                    $emailTo = config('app.email_debug');
                }

                Mail::to($emailTo)
                    ->later($when, new NewContactMail($contact));

            }catch(\Exception $e){
                report($e);
                \Log::error("No se pudo enviar el correo registro de contacto.");
                \Log::error("Contacto id: {$contact->id}");
            }
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
