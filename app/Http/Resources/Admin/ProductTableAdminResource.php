<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProductTableAdminResource extends JsonResource
{

    protected $prefixRouteWeb = "admin.products.";


    public function setParameters($prefixRouteWeb)
    {
        $this->prefixRouteWeb = $prefixRouteWeb;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($request->filled('prefix_route_web')){
            $this->prefixRouteWeb = $request->input('prefix_route_web');
        }

        // icono para editar
        $urlEdit = route($this->prefixRouteWeb.'edit',[$this]);
        $iconEdit =  TableHelper::getIconEdit($urlEdit,"",false);

        // icono para borrar
        $urlRemove = route('api.admin.products.destroy',[$this]);
        $iconRemove = TableHelper::getIconRemove($urlRemove,$this-> id,false);

        $actions = $iconEdit.$iconRemove;

        return [
            'id' => $this-> id,
            'name' => $this-> name,
            'price' => $this-> price,
            'offer_price' => $this->offer_price,
            'display_date_created_at'=>$this-> display_date_created_at,

            'business_name' => $this-> business ? $this->business->name : '-',

            'checkbox'=>TableHelper::getCheckBoxRow($this-> id),
            'actions'=> $actions
        ];
    }
}
