<?php

namespace App;

use App\Helpers\NumberHelper;
use App\Traits\Models\Auditable;
use App\Traits\Models\ImageTrait;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes,ImageTrait,Auditable,CascadeSoftDeletes;

    protected $cascadeDeletes = ['products'];

    protected $table = 'businesses';

    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'price_range_id',
        'district_id',
        'name',
        'email',
        'phone',
        'slug',
        'logo',
        'address',
        'latitude',
        'longitude',
        'description',
        'whatsapp',
        'catalog_link'
    ];

    protected $casts = [
//        'score_average' => 'decimal:2',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function priceRange()
    {
        return $this->belongsTo(PriceRange::class,'price_range_id','id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable','model_type','model_id','id');
    }

    public function providerTypes()
    {
        return $this->belongsToMany(ProviderType::class,'business_provider_type','business_id','provider_type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'business_id','id');
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class,'business_id','id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'business_id','id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class,'business_payment_method','business_id','payment_method_id')
                ->withPivot('access_token', 'public_key','client_id','refresh_token','date_expire_token');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getUrlPageAttribute()
    {
        return route('businesses.by_slug',$this->slug);
    }

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at))
        {
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getScoreAverageAttribute()
    {
        if($this-> reviews){
            return NumberHelper::formatDefault($this-> reviews ->avg('score'));
        }

        return 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this-> reviews->count();
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
     * Trae el storage del negocio
     *
     * @return string
     */
    public function getImageStorage()
    {
        return config("constant.image.business.storage");
    }

    /**
     * Verifica si tiene una categoria
     *
     * @param integer $providerTypeId
     */
    public function haveProviderType($providerTypeId)
    {
        if(count($this->providerTypes) == 0){
            return false;
        }
        return in_array($providerTypeId,$this-> providerTypes->pluck('id')->toArray());
    }


    /**
     * Verifica si tiene una categoria
     *
     * @param District $district
     * @return Shipping
     */
    public function getShippingPriorityDistrict(District $district)
    {

        $shipping = Shipping::where('business_id',$this->id)
            ->where('shippingable_id',$district->id)
            ->where('shippingable_type',District::class)
            ->first();

        // si no existe busca en provincia
        if(!$shipping){
            $shipping = Shipping::where('business_id',$this->id)
                ->where('shippingable_id',$district->province_id)
                ->where('shippingable_type',Province::class)
                ->first();
        }

        // si no existe busca en departamento
        if(!$shipping){
            $shipping = Shipping::where('business_id',$this->id)
                ->where('shippingable_id',$district->province->department->id)
                ->where('shippingable_type',Department::class)
                ->first();
        }

        return $shipping;
    }

}
