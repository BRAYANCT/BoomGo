<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ModalMessageHelper;
use App\Order;
use App\PaymentMethods\PaymentFactory;
use App\Services\BusinessServiceImpl;
use App\Services\OrderServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderWebController extends Controller
{

    private $service;
    private $businessService;

    private $prefixRouteWeb = "orders.";
    private $prefixRouteApi = "api.orders.";

    private $prefixView = "web.order.";

    public function __construct()
    {
        $this-> service = new OrderServiceImpl();
        $this-> businessService = new BusinessServiceImpl();

        view()->share('prefixRouteWeb', $this-> prefixRouteWeb);
        view()->share('prefixRouteApi', $this-> prefixRouteApi);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


    /**
     * Muestra la pagina de checkout
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showCheckout()
    {
        $title = "Procesar compra";
        $description = "";
        return view($this-> prefixView.'checkout',compact('title','description'));
    }

    /**
     * Muestra la pagina de checkout de un negocio
     *
     * @param string $businessSlug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showCheckoutByBusinessSlug(string $businessSlug)
    {

        $business =  $this-> businessService->findBy('slug',$businessSlug);

        if(!$business){
            abort(404);
        }

        $title = "Procesar compra";
        $description = "";
        return view($this-> prefixView.'checkout',compact('title','description','business'));
    }



    /**
     * Guarda la orden del pago .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function updateDataPaymentMethod(Request $request, Order $order)
    {
        $orderGroup = $order->orderGroup;
        $message = array();

        //verifica que la orden permita los pagos
        if(!$order-> allowsPayments()){
            array_push ( $message ,'El pedido no admite permite realizar pagos.');
            $modalMessage = ModalMessageHelper::error($message);
            return redirect(route('checkout.thanks',$orderGroup))
                ->with(['modalMessage'=>$modalMessage]);
        }


        try{
            $paymentFactory = new PaymentFactory($order-> paymentMethod->id);
            $paymentFactory-> paymentMethod-> updateDataPaymentMethod($order,$request->all());

        }catch(\Exception $e){
            report($e);

            array_push ( $message ,$e->getMessage());
            $modalMessage = ModalMessageHelper::error($message);
            return redirect(route('checkout.thanks',$orderGroup))
                ->with(['modalMessage'=>$modalMessage]);
        }

        return redirect(route('checkout.thanks',$orderGroup));
    }

    /**
     * Cambia la orden a pago fallido .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function changeToFailedPayment(Request $request, Order $order)
    {

        $message = array();

        $orderGroup = $order->orderGroup;

        try{
            // $order = $this-> service -> updateDataPaymentMethod($order,$request->all());
            $paymentFactory = new PaymentFactory($order-> paymentMethod->id);
            $paymentFactory-> paymentMethod-> changeToFailedPayment($order,$request->all());

            array_push ( $message ,'No se pudo realizar el pago de su pedido.');
            $modalMessage = ModalMessageHelper::warning($message);
        }catch(\Exception $e){
            report($e);
            array_push ( $message ,$e->getMessage());
            $modalMessage = ModalMessageHelper::error($message);
        }

        return redirect(route('checkout.thanks',$orderGroup))
                ->with(['modalMessage'=>$modalMessage]);
    }
}
