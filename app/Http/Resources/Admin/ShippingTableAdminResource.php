<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingTableAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // icono para editar
//        $urlEdit = route('api.admin.categories.edit',[$this]);

        $iconEdit =  "<a title='Editar' id='edit-item-{$this->id}' class='mr-2' data-id='{$this->id}' onclick='editModalForm(this)' >
                        <i class='fa-2x ".config('constant.icon.edit.class')." ".config('constant.icon.edit.color')."'></i>
                        </a>";

        // icono para borrar
        $urlRemove = route('api.admin.shipping.destroy',[$this]);
        $iconRemove = TableHelper::getIconRemove($urlRemove,$this-> id,false);

        $actions = $iconRemove.$iconEdit;

        return [
            'id' => $this-> id,
            'price' => $this->price,
            'shipping_type_name' => $this->shipping_type_name,

            'shippingable_name' => $this->shippingable->name,
            'shippingable_display_name' => $this->shippingable->display_name,

            'business_name' => $this->business->name,

            'checkbox'=>TableHelper::getCheckBoxRow($this-> id),
            'actions'=> $actions

        ];
    }
}
