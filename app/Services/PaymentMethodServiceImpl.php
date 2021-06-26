<?php


namespace App\Services;


use App\Business;
use App\PaymentMethod;
use App\Repositories\PaymentMethodRepositoryImpl;
use App\Repositories\ShoppingCartRepositoryImpl;
use Illuminate\Support\Collection;
use MercadoPago\Payment;

class PaymentMethodServiceImpl extends GenericServiceImpl implements IPaymentMethodService
{
    private $shoppingCartRepository;

    public function __construct()
    {
        $this-> repository = new PaymentMethodRepositoryImpl();
        $this-> shoppingCartRepository = new ShoppingCartRepositoryImpl();
    }


    /**
     *  Obtiene todos los metodos de pago de los negocios de los productos del carrito de compras.
     *
     * @param string $shoppingCartToken token shopping cart
     * @return collection PaymentMethod::class
     */
    public function findAllOfShoppingCartBusinesses(string $shoppingCartToken)
    {
        $shoppingCart = $this-> shoppingCartRepository->getShoppingCart($shoppingCartToken);

        $paymentMethodsShoppingCart = collect(new PaymentMethod());

        if($shoppingCart){

            $businesses = collect(new Business());

            $shoppingCart->items->each(function ($item, $key) use(&$businesses) {
                $businesses->push($item->product->business);
            });

            // borra los repetidos
            $businesses = $businesses->unique('id');


            $paymentMethodsBusinesses = collect(new PaymentMethod());

            $businesses->each(function ($business, $key) use(&$paymentMethodsBusinesses) {
                $paymentMethodsBusinesses = $paymentMethodsBusinesses->mergeRecursive($this->findAllByBusiness($business));
            });

            $paymentMethods = $this->findAll();

            // verifica que todos los negocios tengan el metodo de pago para agregarlo
            $paymentMethods->each(function ($paymentMethod, $key) use($businesses,$paymentMethodsBusinesses,&$paymentMethodsShoppingCart) {

                $quantityPaymentMethodBusiness = $paymentMethodsBusinesses
                                                    ->where('id',$paymentMethod->id)
                                                    ->count();
                if($quantityPaymentMethodBusiness == count($businesses)){
                    $paymentMethodsShoppingCart->push($paymentMethod);
                }

            });
        }

        return $paymentMethodsShoppingCart;
    }

    /**
     *  Obtiene todos los metodos de pago de un negocio.
     *
     * @param Business $business
     * @return collection PaymentMethod::class
     */
    public function findAllByBusiness(Business $business)
    {
        $parameters = array(
            ['business_id','=',$business->id]
        );

        $paymentMethods = $this->findAllWhere($parameters);

        $parameters = array(
            ['id','=',config('constant.paymentmethod.upon_delivery.id')]
        );
        $uponDelivery = $this->findWhere($parameters);

        // agrega el metodo de pago contraentrega
        $paymentMethods->push($uponDelivery);

        return $paymentMethods;
    }

}
