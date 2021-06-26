<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactTableAdminResource extends JsonResource
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
        $urlShow = route('admin.contacts.show',[$this]);

        $iconShow =  TableHelper::getIconShow($urlShow,false);

        $actions = $iconShow;

        return [
            'id' => $this-> id,

            'display_created_at' => $this-> display_created_at,

            'names' => $this-> names,
            'surnames' => $this-> surnames,
            'email' => $this-> email,
            'phone' => $this-> phone,

            'company_name' => $this-> company_name,

            'actions'=> $actions
        ];
    }
}
