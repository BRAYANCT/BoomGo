<?php


namespace App\Services;


use App\Business;
use App\Department;
use App\District;
use App\Province;
use App\Repositories\ShippingRepositoryImpl;
use App\Repositories\ShoppingCartRepositoryImpl;
use App\Shipping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShippingServiceImpl extends GenericServiceImpl implements IShippingService
{
    private $shoppingCartRepository;

    public function __construct()
    {
        $this-> repository = new ShippingRepositoryImpl();
        $this-> shoppingCartRepository = new ShoppingCartRepositoryImpl();
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Shipping::class
     */
    public function create($data)
    {
        \DB::beginTransaction();
        $shipping = null;
        try {

            $authUser = Auth::user();

            $isAdminBusiness = isset($data['is_admin_business']) ? $data['is_admin_business'] : false;
            $isAdminBusiness = filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN);

//            Log::debug($isAdminBusiness);

            if(!$authUser->canChooseBusiness() || $isAdminBusiness ){
                $data['business_id'] = $authUser->business->id;
            }

            $shippingType = $data['shipping_type'];


            if($shippingType === "department"){
                $shippingableType = Department::class;
                $shippingableId = $data['department_id'];
            }
            else if($shippingType === "province"){
                $shippingableType = Province::class;
                $shippingableId = $data['province_id'];
            }
            else if($shippingType === "district"){
                $shippingableType = District::class;
                $shippingableId = $data['district_id'];
            }

            $data['shippingable_type'] = $shippingableType;
            $data['shippingable_id'] = $shippingableId;

            //guarda el negocio
            $shipping = $this-> repository-> create($data);

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }

        return $shipping;
    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Shipping
     * @throws \Exception
     */
    public function update($data)
    {
        \DB::beginTransaction();
        $shipping = null;
        try {

            $authUser = Auth::user();

            $isAdminBusiness = isset($data['is_admin_business']) ? $data['is_admin_business'] : false;
            $isAdminBusiness = filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN);

            if(!$authUser->canChooseBusiness() || $isAdminBusiness ){
                $data['business_id'] = $authUser->business->id;
            }

            $shippingType = $data['shipping_type'];

            if($shippingType === "department"){
                $shippingableType = Department::class;
                $shippingableId = $data['department_id'];
            }
            else if($shippingType === "province"){
                $shippingableType = Province::class;
                $shippingableId = $data['province_id'];
            }
            else if($shippingType === "district"){
                $shippingableType = District::class;
                $shippingableId = $data['district_id'];
            }

            $data['shippingable_type'] = $shippingableType;
            $data['shippingable_id'] = $shippingableId;

            //guarda el negocio
            $shipping = $this-> repository-> update($data);


            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $shipping;
    }

    /**
     * Obtiene la lista de envios que tiene permitido ver el usuario authenticado segun su role de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Shipping::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false)
    {
        return $this->repository->findAllAllowedForAuthUser($parameters,$relationshipNames,$trashed);
    }


    /**
     * Obtiene todos los envíos del carrito de compras del usuario atenticado
     *
     * @param string $cookieToken token shopping cart
     * @param District $district
     * @return collection Shipping::class
     */
    public function findAllForShoppingCart(string $cookieToken,District $district)
    {
        $shoppingCart = $this-> shoppingCartRepository->getShoppingCart($cookieToken);

        $shippings = collect(new Shipping());

        if($shoppingCart){

            $businesses = collect(new Business());

            $shoppingCart->items->each(function ($item, $key) use(&$businesses) {
                $businesses->push($item->product->business);
            });

            // borra los repetidos
            $businesses = $businesses->unique('id');

//            Log::debug("negocios");
//            Log::debug($businesses);
//            Log::debug($district);

            $businesses->each(function ($business, $key) use(&$shippings,$district) {

                $shipping = $this->findByBusinessAndPriorityDistrict($business,$district);

                if($shipping){
                    $shippings->push($shipping);
                }
            });

        }

        return $shippings;
    }



    /**
     * Obtiene el envio de un negocio priorizando el distrito y si no encuentra agarra la provincia y luego el departamento
     *
     * @param Business $business
     * @param District $district
     * @return Shipping
     */
    public function findByBusinessAndPriorityDistrict(Business $business,District $district)
    {
        return $this->repository->findByBusinessAndPriorityDistrict($business,$district);
    }

}
