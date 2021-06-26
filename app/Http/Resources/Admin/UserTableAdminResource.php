<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class UserTableAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // Log::debug(json_encode($this));

        $role = $this -> getRole();
        $roleName = "";
        if($role){
            $roleName = $role-> display_name;
        }

        // icono para editar
        $urlEdit = route('admin.users.edit',[$this]);
        $iconEdit =  TableHelper::getIconEdit($urlEdit,"",false);

        // icono para borrar
        $urlRemove = route('api.admin.users.destroy',[$this]);
        $iconRemove = TableHelper::getIconRemove($urlRemove,$this-> id,false);

        $actions = $iconEdit.$iconRemove;

        return [
            'id' => $this-> id,
            'names' => $this-> names,
            'surnames' => $this-> surnames,
            'email' => $this-> email,
            'username' => $this-> username,
            'role_name' => $roleName,
            'display_date_created_at'=>$this-> display_date_created_at,
            'checkbox'=>TableHelper::getCheckBoxRow($this-> id),
            'actions'=> $actions
        ];
    }
}
