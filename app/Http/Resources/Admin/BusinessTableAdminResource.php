<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessTableAdminResource extends JsonResource
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
        $urlEdit = route('admin.businesses.edit',[$this]);
        $iconEdit =  TableHelper::getIconEdit($urlEdit,"",false);

        // icono para borrar
        $urlRemove = route('api.admin.businesses.destroy',[$this]);
        $iconRemove = TableHelper::getIconRemove($urlRemove,$this-> id,false);

        $actions = $iconEdit.$iconRemove;

        return [
            'id' => $this-> id,
            'name' => $this-> name,
            'email' => $this-> email,
            'user_username' => $this->user ? $this->user->username : '-',
            'display_created_at'=>$this-> display_created_at,
            'checkbox'=>TableHelper::getCheckBoxRow($this-> id),
            'actions'=> $actions
        ];
    }
}
