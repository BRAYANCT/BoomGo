<?php

namespace App;

use App\Traits\Models\Auditable;
use App\Traits\Models\ImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use ImageTrait,Auditable;

    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'name',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function imageable()
    {
        return $this->morphTo('imageable');
    }


    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y H:i');
        }
    }


    /************************************************************************/
    /***************************** Functions ********************************/
    /************************************************************************/

    /**
     * Trae el storage de la image segun su tipo
     *
     * @return string
     */
    public function getImageStorage()
    {
        if($this->imageable_type == Business::class){
            return config("constant.image.business.storage");
        }else if($this->imageable_type == Product::class){
            return config("constant.image.product.storage");
        }
        return "";
    }

}
