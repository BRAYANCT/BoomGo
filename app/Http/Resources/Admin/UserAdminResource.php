<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this-> id,
            'names' => $this->names,
            'surnames' => $this->surnames,
            'username' => $this->username,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture,
            'user_state_id' => $this->user_state_id,

            'first_name' => $this->first_name,
            'first_surname' => $this->first_surname,
            'full_name' => $this->full_name,

        ];
    }
}
