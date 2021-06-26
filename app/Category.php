<?php

namespace App;

use App\Traits\Models\Auditable;
use App\Traits\Models\ImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ImageTrait,Auditable;

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_type_id',
        'parent_id',
        'name',
        'slug',
        'level',
        'code',
        'picture',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/


    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class,'category_type_id','id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function childs()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'categoryzable');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class,'category_id','id');
    }


    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDefaultPictureUrlAttribute()
    {
        return asset('images/default-placeholder-md.jpg');
    }

    public function getUrlPageAttribute()
    {
        $url = "";
        switch ($this->category_type_id) {
            case config('constant.categorytype.business_id'):
                $url = route('businesses.categories.slug.index',$this->slug);
                break;
            case config('constant.categorytype.product_id'):
                $url = route('products.categories.slug.index',$this->slug);
                break;
        }
        return $url;
    }

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at))
        {
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }


    public function getTotalBusinessesAttribute()
    {
        $totalBusinesses = $this->businesses->count();

        $this->childs->each(function ($item, $key)use(&$totalBusinesses) {
            $totalBusinesses += $item->businesses->count();
        });

        return $totalBusinesses;
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
                    ->where('category_type_id',$data['category_type_id']);
    }

    /************************************************************************/
    /***************************** Functions ********************************/
    /************************************************************************/

    /**
     * Trae el storage de la categoria
     *
     * @return string
     */
    public function getImageStorage()
    {
        return config("constant.image.category.storage");
    }


    /**
     * Verifica si la categoria es valida para tener categorias hijos
     *
     * @return Boolean
     */
    public function canHaveChildren()
    {
        if($this->level == 1){
           return true;
        }
        return false;
    }
}
