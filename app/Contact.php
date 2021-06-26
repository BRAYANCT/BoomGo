<?php

namespace App;

use App\Traits\Models\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Auditable;

    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'names','surnames','phone','email','company_name',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y H:i');
        }
    }

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getDisplayHourCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('H:i');
        }
    }
}
