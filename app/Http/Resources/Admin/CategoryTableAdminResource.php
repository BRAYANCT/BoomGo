<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TableHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTableAdminResource extends JsonResource
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
        $urlEdit = route('admin.categories.edit',[$this]);
        $iconEdit =  TableHelper::getIconEdit($urlEdit,"",false);

        // icono para borrar
        $urlRemove = route('api.admin.categories.destroy',[$this]);
        $iconRemove = TableHelper::getIconRemove($urlRemove,$this-> id,false);

        $actions = $iconEdit.$iconRemove;

        return [
            'id' => $this-> id,
            'name' => $this-> name,
            'display_created_at'=>$this-> display_created_at,

            'parent_name' =>  $this->parent ?  $this->parent->name : '-',

            'checkbox'=>TableHelper::getCheckBoxRow($this-> id),
            'actions'=> $actions
        ];
    }
}
