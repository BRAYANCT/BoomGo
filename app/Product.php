<?php

namespace App;

use App\Helpers\NumberHelper;
use App\Traits\Models\Auditable;
use App\Traits\Models\ImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes,ImageTrait,Auditable;


    protected $table = 'products';

    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'offer_price',
        'offer_start_date',
        'offer_end_date',
        'offer_date_range',
        'picture',
        'active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'offer_date_range'=> 'boolean',
        'active'=> 'boolean',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/


    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryzable');
    }

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
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

    public function getUrlPageAttribute()
    {
        return route('products.by_slug',$this->slug);
    }

    public function setOfferDateRangeAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['offer_date_range'] =  filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
    }

    public function getDisplayOfferStartDateAttribute()
    {
        if(!empty($this-> offer_start_date)){
            return Carbon::parse($this-> offer_start_date)->format('d/m/Y');
        }
    }

    public function setOfferStartDateAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['offer_start_date'] =  Carbon::createFromFormat('d/m/Y', $value)->format('Y/m/d');
        }
    }

    public function getDisplayOfferEndDateAttribute()
    {
        if(!empty($this-> offer_end_date)){
            return Carbon::parse($this-> offer_end_date)->format('d/m/Y');
        }
    }

    public function setOfferEndDateAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['offer_end_date'] =  Carbon::createFromFormat('d/m/Y', $value)->format('Y/m/d');
        }
    }

    public function getOfferActiveAttribute()
    {
        if($this->offer_date_range){
            $todayCarbon = Carbon::today();
            $offerStartDateCarbon =  Carbon::create($this->offer_start_date);
            $offerEndDateCarbon =  Carbon::create($this->offer_end_date);
            return $todayCarbon->greaterThanOrEqualTo($offerStartDateCarbon) && $todayCarbon->lessThanOrEqualTo($offerEndDateCarbon);
        }else{
            return !empty($this->offer_price);
        }
    }

    /**
     * Precio teniendo en cuenta la oferta
     *
     * @return float
     */
    public function getFinalPriceAttribute()
    {
        if($this->offer_active){
            return NumberHelper::formatDefault($this->offer_price);
        }else{
            return NumberHelper::formatDefault($this->price) ;
        }
    }

    /************************************************************************/
    /***************************** Scopes **********************************/
    /************************************************************************/

    /**
     * @param $query
     * @param $slug
     * @param array $data
     * @return
     */
    public function scopeUniqueSlug($query,$slug,$data=[])
    {
        return $query->where('slug',$slug)
                    ->withTrashed();
    }

    /************************************************************************/
    /***************************** Functions ********************************/
    /************************************************************************/

    /**
     * Verifica si el producto esta disponible para ordenar
     *
     * @param  User::class
     * @return boolean
     */
    public function isAvailableToOrder()
    {
        //verifica que se encuentre activo
        if($this-> active){
            return true;
        }
        return false;
    }

    /**
     * Trae el storage del producto
     *
     * @return string
     */
    public function getImageStorage()
    {
        return config("constant.image.product.storage");
    }



}
