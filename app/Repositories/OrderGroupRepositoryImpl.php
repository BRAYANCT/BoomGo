<?php


namespace App\Repositories;


use App\BillingInformation;
use App\Business;
use App\District;
use App\Exceptions\DataBaseGenericException;
use App\Order;
use App\OrderGroup;
use App\ShoppingCart;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderGroupRepositoryImpl extends GenericRepositoryImpl implements IOrderGroupRepository
{

    public function __construct()
    {
        $this-> model = new OrderGroup();
    }

    /**
     * Guarda el registro en la base de datos con todas sus relaciones y crea el usuario con los datos enviados
     *
     * @param array $data
     * @param User $user
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws DataBaseGenericException
     */
    public function createComplete($data,User $user,ShoppingCart $shoppingCart)
    {
        try{

            $districtId = $data['district_id'];

            $billingInformation = BillingInformation::create([
                'district_id' => $districtId,
                'names' => $data['names'],
                'surnames' => $data['surnames'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);

            $orderGroup = $this->model->create([
                'user_id' => $user->id,
                'billing_information_id' => $billingInformation->id,
                'payment_method_id' => $data['payment_method_id'],
            ]);

            $items = $shoppingCart->items;

            $this->createOrdersByItems($items,$orderGroup,$districtId);

//            $items->each(function ($item, $key)use($orderGroup,$districtId) {
//
//                $order = Order::where('order_group_id',$orderGroup->id)
//                    ->where('business_id',$item->product->business_id)
//                    ->first();
//
////                Si no existe la orden la crea
//                if(!$order){
//                    $business = $item->product->business;
//                    $district = District::find($districtId);
//                    $shippingPrice = 0.00;
//
//                    $shipping = $business->getShippingPriorityDistrict($district);
//
//                    if($shipping){
//                        $shippingPrice = $shipping->price;
//                    }
//
//                    $order = Order::create([
//                        'order_group_id' => $orderGroup->id,
//                        'business_id' => $item->product->business_id,
//                        'order_state_id' => config('constant.orderstate.OUTSTANDING_ID'),
//                        'shipping_price' => $shippingPrice,
//                    ]);
//                }
//
//                $item->itemable_id = $order->id;
//                $item->itemable_type = Order::class;
//                $item->name = $item->product->name;
//                $item->price = $item->product->price;
//                $item->offer_price = $item->product->offer_price;
//
//                $item->save();
//
//            });

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return $orderGroup;
    }


    /**
     * Guarda el registro en la base de datos con todas sus relaciones para un negocio
     *
     * @param Business $business
     * @param array $data
     * @param User $user
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws DataBaseGenericException
     */
    public function createCompleteByBusiness(Business $business,$data,User $user,ShoppingCart $shoppingCart)
    {
        try{

            $districtId = $data['district_id'];

            $billingInformation = BillingInformation::create([
                'district_id' => $districtId,
                'names' => $data['names'],
                'surnames' => $data['surnames'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);

            $orderGroup = $this->model->create([
                'user_id' => $user->id,
                'billing_information_id' => $billingInformation->id,
                'payment_method_id' => $data['payment_method_id'],
            ]);

            $items = $shoppingCart->items->where('product.business_id',$business->id);

            $this->createOrdersByItems($items,$orderGroup,$districtId);

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return $orderGroup;
    }

    /**
     * Crea los pedidos de los items enviados
     *
     * @param collection $items
     * @param OrderGroup $orderGroup
     * @param int $districtId
     * @throws DataBaseGenericException
     */
    public function createOrdersByItems($items,$orderGroup,$districtId)
    {
        $items->each(function ($item, $key)use($orderGroup,$districtId) {

            $order = Order::where('order_group_id',$orderGroup->id)
                ->where('business_id',$item->product->business_id)
                ->first();

//                Si no existe la orden la crea
            if(!$order){
                $business = $item->product->business;
                $district = District::find($districtId);
                $shippingPrice = 0.00;

                $shipping = $business->getShippingPriorityDistrict($district);

                if($shipping){
                    $shippingPrice = $shipping->price;
                }

                $order = Order::create([
                    'order_group_id' => $orderGroup->id,
                    'business_id' => $item->product->business_id,
                    'order_state_id' => config('constant.orderstate.OUTSTANDING_ID'),
                    'shipping_price' => $shippingPrice,
                ]);
            }

            $item->itemable_id = $order->id;
            $item->itemable_type = Order::class;
            $item->name = $item->product->name;
            $item->price = $item->product->price;
            $item->offer_price = $item->product->offer_price;

            $item->save();

        });
    }

}
