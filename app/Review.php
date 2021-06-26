<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'score',
        'commentary',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function reviewable()
    {
        return $this->morphTo('reviewable','model_type', 'model_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


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

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    /**
     * Verifica si el tipo de review es negocio
     *
     * @param
     * @return boolean
     */
    public function isBusiness()
    {
        return $this -> model_type == Business::class;
    }

}
