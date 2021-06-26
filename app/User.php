<?php

namespace App;

use App\Notifications\User\ResetPasswordNotification;
use App\Traits\Models\Auditable;
use App\Traits\Models\ImageTrait;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles,Auditable,SoftDeletes,ImageTrait,CascadeSoftDeletes;

    protected $cascadeDeletes = ['business'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'names','surnames','username','email', 'password','profile_picture','api_token','user_state_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function business()
    {
        return $this->hasOne(Business::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'user_id','id');
    }

    public function shoppingCart()
    {
        return $this->hasOne(ShoppingCart::class, 'user_id', 'id');
    }

    public function orderGroups()
    {
        return $this->hasMany(OrderGroup::class,'user_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getFirstNameAttribute()
    {
        $names = $this->attributes['names'];

        $firstName = preg_split("/[\s]+/",$names);
        return $firstName[0];
    }

    public function getFirstSurnameAttribute()
    {
        $surnames = $this->attributes['surnames'];

        $firstSurname = preg_split("/[\s]+/",$surnames);
        return $firstSurname[0];
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['names']." ".$this->attributes['surnames'] ;
    }

    public function getDisplayNameAttribute()
    {
        return $this->first_name." ".$this->first_surname;
    }

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getProfilePictureDefaultUrlAttribute()
    {
        return asset(config('constant.icon.profile.svg'));
    }

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/


    public function routeNotificationForMail()
    {
        if(config('app.mail_debug')){
            return config('app.email_debug');
        }
        return $this-> email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Verifica si tiene como top level role es administrador del sistema
     *
     * @param
     * @return boolean
     */
    public function isAdminSys()
    {
        $role =  $this->getRole();
        if($role){
            return $role->isAdminSys();
        }
        return false;
    }


    /**
     * Verifica si tiene como top level role es administrador
     *
     * @param
     * @return boolean
     */
    public function isAdmin()
    {
        $role = $this->getRole();
        if($role){
            return $role->isAdmin();
        }
        return false;
    }

    /**
     * Verifica si es vendedor
     *
     * @param
     * @return boolean
     */
    public function isVendor()
    {
        $role = $this->getRole();
        if($role){
            return $role->isVendor();
        }
        return false;
    }

    /**
     * Verifica si es cliente
     *
     * @param
     * @return boolean
     */
    public function isCustomer()
    {
        $role = $this->getRole();
        if($role){
            return $role->isCustomer();
        }
        return false;
    }

    /**
     * Obtiene un Rol
     *
     * @param  roles collection
     * @return role model
    */
    public function getRole()
    {
        return $this->roles->first();
    }

    /**
     * Obtiene el url de la primera pagina luego de authenticarse
     *
     * @return string (url de inicio)
     */
    public function getFirstPageAuth()
    {
        $route = "/";
        if($this->isAdminSys()) {
            $route = route('admin.users.index');
        }else if($this->isAdmin()) {
            $route = route('admin.users.index');
        }else if($this->isVendor()) {
            $route = route('admin.users.profile.edit');
        }else if($this->isCustomer()) {
            $route = route('index');
        }
        return $route;
    }

        /**
     * Obtiene el url de la pagina de logout segun el paciente
     *
     * @param
     * @return string(url de inicio)
     */
    public function getLogOutPage()
    {
        return route('index');
    }


    /**
     * Trae el storage de la imagen de perfil
     *
     * @return string
    */
    public function getImageStorage()
    {
        return config("constant.image.user.storage");
    }

    /**
     * Verifica si el rol del usuario puede elegir un negocio
     *
     * @return Boolean
     */
    public function canChooseBusiness()
    {
        return $this->getRole()->canChooseBusiness();
    }


    /**
     * Verifica si el usuario tiene permisos para realizar acciones en el usuario
     *
     * @param \App\User $user
     * @return Boolean
     */
    public function havePermissionCrudUser(User $user)
    {
        // Si el usuario no es administrador del sistema
        // No puede realizar accion sobre un rol de administrador del sistema
        if(!$this->isAdminSys()){
            return !$user->isAdminSys();
        }
        return true;
    }

    /**
     * Verifica si el usuario tiene permisos para realizar acciones en el producto
     *
     * @param Product $product
     * @return Boolean
     */
    public function havePermissionCrudProduct(Product $product)
    {
        if(!$this->canChooseBusiness()){
            return $this->business ? $this->business->id == $product->business_id : false;
        }
        return true;
    }


    /**
     * Verifica si el usuario tiene permisos para realizar acciones en la orden
     *
     * @param \App\Order $order
     * @return Boolean
     */
    public function havePermissionCrudOrder(Order $order)
    {
        //Si el usuario es administrador de sistema o super admin puede ver todo
        if(!$this->isAdminSys() && !$this->isAdmin()){

//          Si es vendedor o comprador y el pedido es suyo tiene permisos
            if($order-> user->id == $this-> id){
                return true;
            }

            // si es vendedor verifica que el pedido pertenezca a su negocio
            if($this->isVendor()){
                return $order->business ? $this->business->id == $order->business_id : false ;
            }

            return false;
        }
        return true;
    }

    /**
     * Verifica si el usuario tiene permisos para realizar acciones al group de orden
     *
     * @param OrderGroup $orderGroup
     * @return Boolean
     */
    public function havePermissionCrudOrderGroup(OrderGroup $orderGroup)
    {
        //Si el usuario es administrador de sistema o super admin puede ver todo
        if(!$this->isAdminSys() && !$this->isAdmin()){
            //verifica que la orden se pertenesca al usuario autenticado
            return $orderGroup-> user_id == $this-> id;
        }
        return true;
    }

    /**
     * Verifica si el usuario tiene permisos para realizar acciones en el envio
     *
     * @param Shipping $shipping
     * @return Boolean
     */
    public function havePermissionCrudShipping(Shipping $shipping)
    {
        if(!$this->canChooseBusiness()){
            return $this->business ? $this->business->id == $shipping->business_id : false;
        }
        return true;
    }

    /**
     * Verifica si el usuario tiene permisos para realizar acciones para el negocio
     *
     * @param Business $business
     * @return Boolean
     */
    public function havePermissionCrudBusiness(Business $business)
    {
        if(!$this->canChooseBusiness()){
            return $this->business ? $this->business->id == $business->id : false;
        }
        return true;
    }

    /**
     * Verifica si el usuario tiene permisos para realizar acciones en la imagen
     *
     * @param Image $image
     * @return Boolean
     */
    public function havePermissionCrudImage(Image $image)
    {

//        \Log::debug('havePermissionCrudImage');

        if(!$this->isAdminSys() && !$this->isAdmin() ){

            $imageable = $image->imageable;

            if($imageable){
                if($image->imageable_type == Business::class){
                    return $imageable->user_id == $this->id;
                }else if($image->imageable_type == Product::class){
                    return $imageable-> business ? $imageable-> business->user_id == $this->id : false;
                }
            }
            return false;
        }
        return true;
    }



}
