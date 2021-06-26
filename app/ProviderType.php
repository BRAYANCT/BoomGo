<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderType extends Model
{
    protected $table = 'provider_types';

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/


    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

}
