<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTableAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // icono para ver el detalle
        $urlShow = route('admin.orders.show',[$this]);

        if($request->filled('is_admin_business')){
            $isAdminBusiness = filter_var($request->input('is_admin_business'), FILTER_VALIDATE_BOOLEAN);
            if($isAdminBusiness){
                $urlShow = route('businesses_admin.orders.show',[$this]);
            }
        }

        $iconShow =  TableHelper::getIconShow($urlShow,false);

        $actions = $iconShow;

        return [
            'id' => $this-> id,
            'display_created_at' => $this-> display_created_at,
            'code' => $this-> code,
            'total' => $this-> total,
            'quantity_total' => $this-> quantity_total,

            'business_name' => $this-> business->name,
            'user_full_name' => $this->user-> full_name,
            'user_display_name' => $this->user-> display_name,
            'order_state_name' => $this->orderState-> name,
            'order_state_badge' => $this->orderState-> badge,
            'payment_method_name' => $this->paymentMethod-> name,

            'actions'=> $actions
        ];
    }
}
