<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserState extends Model
{
    protected $table = 'user_states';


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function users()
    {
        return $this->hasMany(User::class,'user_state_id','id');
    }
}
