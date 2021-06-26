<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimTableAdminResource extends JsonResource
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
        $urlShow = route('admin.claims.show',[$this]);

        $iconShow =  TableHelper::getIconShow($urlShow,false);

        $actions = $iconShow;

        return [
            'id' => $this-> id,

            'display_created_at' => $this-> display_created_at,

            'full_name' => $this-> names." ".$this->surnames,
            'email' => $this-> email,
            'phone' => $this-> phone,

            'code' => $this-> code,

            'actions'=> $actions
        ];
    }
}
