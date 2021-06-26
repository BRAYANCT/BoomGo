<?php

namespace App\PaymentMethods;

use App\Business;
use App\Order;
use App\PaymentMethods\IPayment;
use App\Services\OrderServiceImpl;
use App\Services\TransactionServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;
use phpDocumentor\Parser\Exception;
use PhpParser\Node\Expr\Cast\Object_;

class MercadoPago implements IPayment
{


    private $transactionService;
    private $orderService;

    private $accessToken;
    private $marketPlaceRedirectUrl;

//    private $testAccessToken;

    public function __construct()
    {

        $this->marketPlaceRedirectUrl = config('constant.paymentmethod.mercadopago.market_place_redirect_url');

//        $this->testAccessToken = config('constant.paymentmethod.mercadopago.test_access_token');

        if (config('constant.paymentmethod.use_sandbox')) {
            $this->accessToken = config('constant.paymentmethod.mercadopago.test_access_token');
        }else{
            $this->accessToken = config('constant.paymentmethod.mercadopago.access_token');
        }

        SDK::setAccessToken($this->accessToken);

//        SDK::setClientId(
//            config("constant.paymentmethod.mercadopago.client")
//        );
//
//        SDK::setClientSecret(
//            config("constant.paymentmethod.mercadopago.secret")
//        );


        $this-> transactionService = new TransactionServiceImpl();
        $this-> orderService = new OrderServiceImpl();

        Log::debug("accessToken:".$this->accessToken);

    }


    /**
     * Crea las credenciales del vendedor para poder hacer el split de pagos
     *
     * @param string $authCode
     * @return Object
     */
    public function createCredentialsVendor(string $authCode)
    {

            //API URL
//        $url = "https://api.mercadopago.com/oauth/token?client_secret={$this->testAccessToken}&grant_type=authorization_code&code={$authCode}&redirect_uri={$this->marketPlaceRedirectUrl}";

        $url = "https://api.mercadopago.com/oauth/token?grant_type=authorization_code&code={$authCode}&redirect_uri={$this->marketPlaceRedirectUrl}";

//        Log::debug($url);

        //create a new cURL resource
        $ch = curl_init($url);

        //
        $data = array(
            "client_secret={$this->accessToken}",
        );

        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $headers = array(
            'accept: application/json',
            'content-type: application/x-www-form-urlencoded'
        );

        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);

        $resultJson =json_decode($result);

        //close cURL resource
        curl_close($ch);

        Log::debug(json_encode($result));
//        Log::debug("status:".$resultJson->status);
//        Log::debug("accessToken:".$resultJson->message);


        if(isset($resultJson->status)){
            throw new \Exception($resultJson->message,500);
        }


        return $resultJson;
    }

    /**
     * Genera el pago de un pedido
     *
     * @param Order $order
     * @param array $data
     * @return array
     */
    public function generatePaymentSplit(Order $order,array $data): array
    {

        //API URL
        $url = 'https://api.mercadopago.com/v1/advanced_payments';

        //create a new cURL resource
        $ch = curl_init($url);

        //setup request to send json via POST
        $data = array(
            "payer" => [
                "email"=> "test_user_11439624@testuser.com"
            ],
            "payments"=> [
                [
                    "payment_method_id"=> $data['paymentMethodId'],
                    "payment_type_id"=> "credit_card",
                    "token"=> $data['cardToken'],
                    "transaction_amount"=> (float) $data['transactionAmount'],
                    "installments"=> (int)$data['installments'],
                    "processing_mode"=> "aggregator"
                ]
            ],
            "disbursements"=> [
                [
                    "amount"=> (float) $data['transactionAmount'],
                    "external_reference"=> "ref-collector-1",
                    "collector_id"=> 673245296,
                    "application_fee"=> 20,
                    "money_release_days"=> 30
                ],
           ],
            "external_reference"=>"ref-transaction",
//            "binary_mode"=>true,
        );

        $payload = json_encode($data);

        Log::debug($payload);

        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $headers = array(
            'Authorization: Bearer APP_USR-7333696390310956-111614-4327eec0affbd1f0f0115df8a21687b7-565994499',
            'Content-Type:application/json'
        );

        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);

        Log::debug(json_encode($result));

        //close cURL resource
        curl_close($ch);

    }

    /**
     * Genera el pago de un pedido
     *
     * @param Order $order
     * @param array $data
     * @return array
     */
    public function generatePayment(Order $order,array $data): array
    {

        Log::debug(json_encode($data));

//        SDK::setAccessToken('APP_USR-6357799118358915-111917-6a8b7ccbf7cb00b8c40ba29bd1b13db3-565994499');

        $payment = new Payment();
        $payment->transaction_amount = (float) $data['transactionAmount'];
        $payment->token = $data['cardToken'];
        $payment->description = 'Esta es mi descripcion';
        $payment->installments = (int)$data['installments'];
        $payment->payment_method_id = $data['paymentMethodId'];
//        $payment->issuer_id = 1;

        $payer = new Payer();
        $payer->email = $data['email'];
        $payer->identification = array(
            "type" => $data['docType'],
            "number" => $data['doc_number']
        );

        $payment->payer = $payer;
        $payment->save();


//        Log::debug(json_encode($payment));
//        Log::debug($payment->status);
//        Log::debug($payment->status_detail);
//        Log::debug($payment->id);

        return array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );

    }


    /**
    * Genera el metodo de pago y retorna el url
    *
    * @param Order $order
    * @return String
    */
    public function setUpPaymentAndGetRedirectURL(Order $order): string
    {

        $this->setAccessTokenByBusiness($order->business);

        # Create a preference object
        $preference = new Preference();

        $preference-> payment_methods = array(
        // "excluded_payment_methods" => array(
        //   array("id" => "master")
        // ),
        "excluded_payment_types" => array(
            array("id" => "ticket"),
            array("id" => "bank_transfer"),
        ),
        "installments" => 12
        );


        # Create an item object
        $item = new Item();
        $item-> id = $order-> code;
        $item-> title = $order-> code;
        $item-> quantity = 1;
        $item-> currency_id = 'PEN';
        $item-> unit_price = $order-> total;
        // $item-> picture_url = ;

        # Create a payer object
        $payer = new Payer();

        if(config('constant.paymentmethod.use_sandbox')) {
            $payer-> email = 'test_user_11439624@testuser.com';
        }else{
            $payer-> email = $order-> user-> email;
        }


        # Setting preference properties
        $preference-> items = [$item];
        $preference-> payer = $payer;

        # Save External Reference
        $preference-> external_reference = $order-> id;


        $preference-> back_urls = [
            "success" => route('orders.data_payment_method.update',$order),
//            "pending" => route('shop.checkout.pending',$order),
            "failure" => route('orders.change_to_failed_payment',$order),
        ];

        // $preference-> auto_return = "approved";

        $preference-> auto_return = "all";

        $preference-> binary_mode = true;

//        $preference-> notification_url = route('ipn');

        # Save and POST preference
        $preference->save();

        // if (config('paymentmethod.use_sandbox')) {
        //   return $preference-> sandbox_init_point;
        // }

        return $preference-> init_point;
    }


    /**
    * Guarda la informacion en la base de datos referente al pago
    *
    * @param Order $order
    * @param array $data datos que envia la plataforma de pagos
    * @return Boolean
    */
    public function updateDataPaymentMethod(Order $order,$data)
    {
        $this->setAccessTokenByBusiness($order->business);

        // Fallido que no han cobrado y un fallido que te han cobrado

        $merchant_order = null;

        try {

            $merchant_order = MerchantOrder::find_by_id($data['merchant_order_id']);

            // verifica que la orden exista
            if($merchant_order){

                // verifica que la orden del sistema pertenesca a la orden de mercado pago
                if($order-> id != $merchant_order-> external_reference){
                    abort(403,trans('crud.authorization_failed'));
                }


                // Verifica los pagos
                if(count($merchant_order-> payments)>0){

                    $paid_amount = 0;
                    foreach ($merchant_order-> payments as $payment) {
                        if ($payment-> status == 'approved'){
                            $paid_amount += $payment-> transaction_amount;
                        }
                    }

                    // si los pagos
                    // if($paid_amount >= $merchant_order-> total_amount){
                    if($paid_amount >= $order-> total_with_commission){

                        // Log::debug('La orden está pagada proceder a guardar los datos');

                        $dataUpdateOrder = array(
                            'id'=> $merchant_order-> external_reference,
                            'order_code_payment_method' =>  $data['merchant_order_id'],
                            'order_state_id' => config('constant.orderstate.PAID_OUT_ID'),
                        );

                        //actualiza los datos de la orden
                        $this-> orderService->updateDataPaymentMethod($order,$dataUpdateOrder);

                        // solo se va a realizar una transaccion por orden
                        $transaction = $merchant_order-> payments[0];

                        $dataCreateTransaction = array(
                                                      'order_id' => $merchant_order-> external_reference,
                                                      'external_reference'=> $transaction-> id,
                                                      'total_amount'=> $transaction-> transaction_amount,
                                                    );

                        // guarda la transaccion en la base de datos
                        $this-> transactionService ->create($dataCreateTransaction);

                    }

                }

            }else{
                abort(404);
            }

        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }



    /**
    * Cambia la orden a pago fallido
    *
    * @param Order $order
    * @param array $data datos que envia la plataforma de pagos
    * @return Boolean
    */
    public function changeToFailedPayment(Order $order,$data)
    {
        $this->setAccessTokenByBusiness($order->business);

        // Fallido que no han cobrado y un fallido que te han cobrado

        $merchant_order = null;

        // Log::debug(json_encode($data));

        try {

            $merchantOrderId  = $data['merchant_order_id'];

            if($merchantOrderId && $merchantOrderId != 'null'){

                $merchant_order = MerchantOrder::find_by_id($merchantOrderId);


                // verifica que la orden exista
                if($merchant_order){

                  // verifica que la orden del sistema pertenesca a la orden de mercado pago
                  if($order-> id != $merchant_order-> external_reference){
                    abort(403,trans('crud.authorization_failed'));
                  }

                  //actualiza los datos de la orden
                  $this-> orderService->changeToFailedPayment($order);

                }

            }


        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * Pone el token del negocio
     *
     * @param Business $business
     */
    public function setAccessTokenByBusiness(Business $business)
    {
        $paymentMethod = $business->paymentMethods->where('id',config('constant.paymentmethod.mercadopago.id'))->first();
        $accessToken = $paymentMethod->pivot->access_token;
        SDK::setAccessToken($accessToken);
    }

}
