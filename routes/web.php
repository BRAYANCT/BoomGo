<?php

use App\Http\Controllers\Admin\BusinessAdminController;
use App\Http\Controllers\Admin\BusinessPaymentMethodAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\ClaimAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\ImageAdminController;
use App\Http\Controllers\Admin\MercadoPagoAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\OrderGroupAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ShippingAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\Web\BusinessWebController;
use App\Http\Controllers\Web\ClaimWebController;
use App\Http\Controllers\Web\ImageWebController;
use App\Http\Controllers\Web\OrderGroupWebController;
use App\Http\Controllers\Web\OrderWebController;
use App\Http\Controllers\Web\PageWebController;
use App\Http\Controllers\Web\ProductWebController;
use App\Http\Controllers\Web\ShoppingCartWebController;
use App\PaymentMethods\MercadoPago;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [PageWebController::class, 'index'])
		->name('index');

Route::get('/politicas-de-cookies', [PageWebController::class, 'showCookiePolicies'])
    ->name('cookie.policies');

Route::get('/politicas-de-privacidad', [PageWebController::class, 'showPrivacyPolicies'])
    ->name('privacy.policies');


//**********************************************************************//
//********************** Routes Claims *********************************//
//*********************************************************************//

Route::get('libro-de-reclamaciones', [ClaimWebController::class, 'create'])
    ->name('claims.create');

//**********************************************************************//
//********************** Fin de routes Claims **************************//
//*********************************************************************//

//**********************************************************************//
//********************** Routes Businesses *****************************//
//*********************************************************************//

Route::get('negocios', [BusinessWebController::class, 'index'])
    ->name('businesses.index');

Route::get('negocios/{slug}', [BusinessWebController::class, 'showBySlug'])
    ->name('businesses.by_slug');

Route::get( 'negocios/categorias/{slug}',[BusinessWebController::class,'getAllByCategorySlug'])
    ->name('businesses.categories.slug.index');

//**********************************************************************//
//********************** Fin de routes Businesses **********************//
//*********************************************************************//


//**********************************************************************//
//********************** Routes Products *****************************//
//*********************************************************************//

Route::get('market-place', [ProductWebController::class, 'index'])
    ->name('products.index');

Route::get('market-place/negocios/{slug}', [ProductWebController::class, 'getAllByBusinessSlug'])
    ->name('products.businesses.by_slug');

Route::get('market-place/negocios/{businessSlug}/categorias/{categorySlug}', [ProductWebController::class, 'getAllByBusinessSlugAndCategorySlug'])
    ->name('products.businesses.slug.categories.slug');


Route::get('market-place/{slug}', [ProductWebController::class, 'showBySlug'])
    ->name('products.by_slug');

Route::get( 'market-place/categorias/{slug}',[ProductWebController::class,'getAllByCategorySlug'])
    ->name('products.categories.slug.index');

//**********************************************************************//
//********************** Fin de routes Products **********************//
//*********************************************************************//


//**********************************************************************//
//********************** Routes Image public ***************************//
//*********************************************************************//

Route::get('images-public/{path}/{imageName}', [ImageWebController::class,'showImageStorage'])
		->name('images.storage.show');

Route::get('/images-public-fit/{path}/{width}/{height}/{imageName}',[ImageWebController::class,'showImageFit'])
		->name('images_fit.show')
		->where(['width'=>'[0-9]{1,3}+','height'=>'[0-9]{1,3}+']);

Route::get('/images-public-resize/{path}/{width}/{height}/{imageName}',[ImageWebController::class,'showImageResize'])
			->name('images_resize.show')
			->where(['width'=>'[0-9]{1,3}+','height'=>'[0-9]{1,3}+']);

//**********************************************************************//
//********************** Fin de routes Image public ******************//
//*********************************************************************//

//**********************************************************************//
//********************** Routes Shopping Carts *************************//
//*********************************************************************//

Route::get('/shopping-carts', [ShoppingCartWebController::class, 'index'])
    ->name('shopping_carts.index');

//**********************************************************************//
//********************** Fin de Shopping Carts *************************//
//*********************************************************************//



//**********************************************************************//
//********************** Routes Orders *********************************//
//*********************************************************************//

Route::get('/checkout', [OrderWebController::class, 'showCheckout'])
    ->name('order.checkout.index');

Route::get('/checkout/businesses/{businessSlug}', [OrderWebController::class, 'showCheckoutByBusinessSlug'])
    ->name('order.checkout.businesses.businessSlug.index');

//Route::get('/checkout/{order}/thanks', [OrderWebController::class, 'showCheckoutThanks'])
//    ->name('checkout.thanks')
//    ->middleware('auth.user.permission.crud.order');


//**********************************************************************//
//********************** Fin de Orders *********************************//
//*********************************************************************//


//**********************************************************************//
//******************** Routes Mercado Pago *****************************//
//*********************************************************************//

Route::get('/mercado-pago/market-place-redirect',[MercadoPagoController::class, 'createOrEditForAuthUser'])
    ->name('businesses.profile.create_edit');


//**********************************************************************//
//******************* Fin routes Mercado Pago **************************//
//*********************************************************************//


Route::group(['middleware' => 'auth'], function(){

//**********************************************************************//
//********************** Routes Order Group *********************************//
//*********************************************************************//

    Route::get('/checkout/{orderGroup}/thanks', [OrderGroupWebController::class, 'showCheckoutThanks'])
        ->name('checkout.thanks')
        ->middleware('auth.user.permission.crud.order.group');

//**********************************************************************//
//********************** Fin de Orders Group *********************************//
//*********************************************************************//

//**********************************************************************//
//********************** Routes Order *********************************//
//*********************************************************************//

    Route::get('/orders/{order}/data-payment-method/update', [OrderWebController::class, 'updateDataPaymentMethod'])
        ->name('orders.data_payment_method.update')
        ->middleware('auth.user.permission.crud.order');

    Route::get('/orders/{order}/change-to-failed-payment', [OrderWebController::class, 'changeToFailedPayment'])
        ->name('orders.change_to_failed_payment')
        ->middleware('order.can.change.to.failed_payment');

//**********************************************************************//
//********************** Fin de Orders *********************************//
//*********************************************************************//

});



Auth::routes();

//***********************************************************************************/
/************************* Routes con authenticacion ********************************/
//***********************************************************************************/

Route::group(['prefix' => 'businesses-admin','as' => 'businesses_admin.','middleware' => 'auth'], function(){

    //**********************************************************************//
    //********************** Routes Businesses *****************************//
    //*********************************************************************//

    Route::get('/negocios/perfil',[BusinessAdminController::class, 'createOrEditForAuthUser'])
        ->name('businesses.profile.create_edit')
        ->middleware('permission:businesses_admin_businesses_profile_create_edit');

    Route::post('/negocios/perfil', [BusinessAdminController::class, 'storeOrUpdateForAuthUser'])
        ->name('businesses.profile.store_update')
        ->middleware('permission:businesses_admin_businesses_profile_store_update');

    //**********************************************************************//
    //********************** Fin routes Businesses *************************//
    //*********************************************************************//

    Route::group(['middleware' => 'check.is.auth.user.has.business'], function() {

        //**********************************************************************//
        //********************** Routes Products *******************************//
        //*********************************************************************//

        Route::get('/productos', [ProductAdminController::class, 'index'])
            ->name('products.index')
            ->middleware('permission:businesses_admin_products_index');

        Route::get('/productos/create', [ProductAdminController::class, 'create'])
            ->name('products.create')
            ->middleware('permission:businesses_admin_products_create');

        Route::get('/productos/{product}/edit', [ProductAdminController::class, 'edit'])
            ->name('products.edit')
            ->middleware([
                'permission:businesses_admin_products_edit',
                'auth.user.permission.crud.product'
            ]);

        //**********************************************************************//
        //********************** Fin routes Products ***************************//
        //*********************************************************************//


        //**********************************************************************//
        //********************** Routes Shippings ******************************//
        //*********************************************************************//


        Route::get('/envios', [ShippingAdminController::class, 'showFormList'])
            ->name('shipping.index')
            ->middleware('permission:admin_shipping_form_list_index');


        //**********************************************************************//
        //********************** Fin de routes Shippings ***********************//
        //*********************************************************************//

        //**********************************************************************//
        //**************** Routes Business Payment Method **********************//
        //*********************************************************************//

        Route::get('/metodos-de-pago', [BusinessPaymentMethodAdminController::class, 'showPageByBusinessAuthUser'])
            ->name('business_payment_method.index')
            ->middleware('permission:businesses_admin_business_payment_method_index');

        //**********************************************************************//
        //*************** Fin de routes Business Payment Method ****************//
        //*********************************************************************//

        //**********************************************************************//
        //************************ Routes Orders *******************************//
        //*********************************************************************//

        Route::get('/pedidos-de-mi-negocio', [OrderAdminController::class, 'getAllForBusinessAuthUser'])
            ->name('orders.auth_user_business.index')
            ->middleware('permission:businesses_admin_orders_auth_user_business_index');

        Route::get('/pedidos/{order}', [OrderAdminController::class, 'show'])
            ->name('orders.show')
            ->middleware([
                'permission:businesses_admin_orders_show',
                'auth.user.permission.crud.order'
            ]);

        //**********************************************************************//
        //************************ Fin de routes Orders ************************//
        //*********************************************************************//
    });

});



Route::group(['prefix' => 'admin','as' => 'admin.','middleware' => 'auth'], function(){

	//**********************************************************************//
	//********************** Routes Image **********************************//
	//*********************************************************************//

	Route::get('images/{path}/{imageName}',[ImageAdminController::class, 'showImageStorage'])
		->name('images.storage.show')
		->middleware('permission:admin_images_storage_show');

	Route::get('/images-fit/{path}/{width}/{height}/{imageName}',[ImageAdminController::class, 'showImageFit'])
		->name('images_fit.show')
		->where(['width'=>'[0-9]{1,3}+','height'=>'[0-9]{1,3}+'])
		->middleware('permission:admin_images_fit_show');

	Route::get('/images-resize/{path}/{width}/{height}/{imageName}',[ImageAdminController::class,'showImageResize'])
		->name('images_resize.show')
		->where(['width'=>'[0-9]{1,3}+','height'=>'[0-9]{1,3}+'])
		->middleware('permission:admin_images_resize_show');

	//**********************************************************************//
	//********************** Fin routes Images *****************************//
	//*********************************************************************//

	//**********************************************************************//
	//********************** Routes Users **********************************//
	//*********************************************************************//

// la rutas de perfil van primero porque el usuario tiene el edit dinamico
	Route::get('/usuarios/perfil/edit',[UserAdminController::class, 'editProfile'])
				->name('users.profile.edit')
				->middleware('permission:admin_users_profile_edit');

	Route::put('/usuarios/perfil', [UserAdminController::class, 'updateProfile'])
				->name('users.profile.update')
				->middleware('permission:admin_users_profile_update');


	Route::get('/usuarios', [UserAdminController::class, 'index'])
				->name('users.index')
				->middleware('permission:admin_users_index');

	Route::get('/usuarios/create', [UserAdminController::class, 'create'])
				->name('users.create')
				->middleware('permission:admin_users_create');

	Route::post('/usuarios', [UserAdminController::class, 'store'])
				->name('users.store')
				->middleware('permission:admin_users_store');

	Route::get('/usuarios/{user}/edit', [UserAdminController::class, 'edit'])
				->name('users.edit')
				->middleware([
								'permission:admin_users_edit',
								'auth.user.permission.crud.user'
							]);

	Route::put('/usuarios/{user}', [UserAdminController::class, 'update'])
				->name('users.update')
				->middleware([
								'permission:admin_users_update',
								'auth.user.permission.crud.user'
							]);

	Route::delete('/usuarios/{user}', [UserAdminController::class, 'destroy'])
				->name('users.destroy')
				->middleware([
								'permission:admin_users_destroy',
								'auth.user.permission.crud.user'
							]);


	//**********************************************************************//
	//********************** fin de routes Users **************************//
	//*********************************************************************//


    //**********************************************************************//
    //********************** Routes Businesses *****************************//
    //*********************************************************************//


    Route::get('/negocios', [BusinessAdminController::class, 'index'])
        ->name('businesses.index')
        ->middleware('permission:admin_businesses_index');

    Route::get('/negocios/create', [BusinessAdminController::class, 'create'])
        ->name('businesses.create')
        ->middleware('permission:admin_businesses_create');

    Route::post('/negocios', [BusinessAdminController::class, 'store'])
        ->name('businesses.store')
        ->middleware('permission:admin_businesses_store');

    Route::get('/negocios/{business}/edit', [BusinessAdminController::class, 'edit'])
        ->name('businesses.edit')
        ->middleware('permission:admin_businesses_edit');

    Route::put('/negocios/{business}', [BusinessAdminController::class, 'update'])
        ->name('businesses.update')
        ->middleware('permission:admin_businesses_update');

    Route::delete('/negocios/{business}', [BusinessAdminController::class, 'destroy'])
        ->name('businesses.destroy')
        ->middleware('permission:admin_businesses_destroy');

    //**********************************************************************//
    //********************** Fin de routes Businesses **********************//
    //*********************************************************************//


    //**********************************************************************//
    //********************** Routes Businesses *****************************//
    //*********************************************************************//


    Route::get('/productos', [ProductAdminController::class, 'index'])
        ->name('products.index')
        ->middleware('permission:admin_products_index');

    Route::get('/productos/create', [ProductAdminController::class, 'create'])
        ->name('products.create')
        ->middleware('permission:admin_products_create');

//    Route::post('/productos', [ProductAdminController::class, 'store'])
//        ->name('products.store')
//        ->middleware('permission:admin_products_store');

    Route::get('/productos/{product}/edit', [ProductAdminController::class, 'edit'])
        ->name('products.edit')
        ->middleware([
            'permission:admin_products_edit',
            'auth.user.permission.crud.product'
        ]);

//    Route::put('/productos/{product}', [ProductAdminController::class, 'update'])
//        ->name('products.update')
//        ->middleware('permission:admin_products_update');

//    Route::delete('/productos/{product}', [ProductAdminController::class, 'destroy'])
//        ->name('products.destroy')
//        ->middleware('permission:admin_products_destroy');

    //**********************************************************************//
    //********************** Fin de routes Businesses **********************//
    //*********************************************************************//


    //**********************************************************************//
    //********************** Routes Categories *****************************//
    //*********************************************************************//

    Route::get('/categorias/{categoryTypeSlug}', [CategoryAdminController::class, 'getAllByCategoryTypeSlug'])
        ->name('categories.category_type_slug.index')
        ->middleware('permission:admin_categories_index');

    Route::get('/categorias/{categoryTypeSlug}/create', [CategoryAdminController::class, 'createByCategoryTypeSlug'])
        ->name('categories.category_type_slug.create')
        ->middleware('permission:admin_categories_create');

    Route::post('/categorias', [CategoryAdminController::class, 'store'])
        ->name('categories.store')
        ->middleware('permission:admin_categories_store');

    Route::get('/categorias/{category}/edit', [CategoryAdminController::class, 'edit'])
        ->name('categories.edit')
        ->middleware('permission:admin_categories_edit');

    Route::put('/categorias/{category}', [CategoryAdminController::class, 'update'])
        ->name('categories.update')
        ->middleware('permission:admin_categories_update');

    Route::delete('/categorias/{category}', [CategoryAdminController::class, 'destroy'])
        ->name('categories.destroy')
        ->middleware('permission:admin_categories_destroy');

    //**********************************************************************//
    //********************** Fin de routes Categories **********************//
    //*********************************************************************//


    //**********************************************************************//
    //********************** Routes Shippings ******************************//
    //*********************************************************************//

    Route::get('/envios', [ShippingAdminController::class, 'showFormList'])
        ->name('shipping.index')
        ->middleware('permission:admin_shipping_form_list_index');

    //**********************************************************************//
    //********************** Fin de routes Shippings ***********************//
    //*********************************************************************//


    //**********************************************************************//
    //****************** Routes Business Payment Method ********************//
    //*********************************************************************//

    Route::get('/metodos-de-pago', [BusinessPaymentMethodAdminController::class, 'index'])
        ->name('business_payment_method.index')
        ->middleware('permission:admin_business_payment_method_index');

    //**********************************************************************//
    //***************** Fin de routes Business Payment Method **************//
    //*********************************************************************//


    //**********************************************************************//
    //******************** Routes Mercado Pago *****************************//
    //*********************************************************************//

    Route::get('/mercado-pago/market-place-authorization',[MercadoPagoAdminController::class, 'redirectMarketPlaceAuthorization'])
        ->name('mercado_pago.market_place_authorization');

    //**********************************************************************//
    //******************* Fin routes Mercado Pago **************************//
    //*********************************************************************//

    //**********************************************************************//
    //********************** Routes Orders *********************************//
    //*********************************************************************//

    Route::get('/menu-mis-compras', [OrderAdminController::class, 'getMenuForAuthUser'])
        ->name('orders.menu_auth_user.index')
        ->middleware('permission:admin_orders_menu_auth_user_index');

    Route::get('/mis-compras', [OrderAdminController::class, 'getAllForAuthUser'])
        ->name('orders.auth_user.index')
        ->middleware('permission:admin_orders_auth_user_index');

    Route::get('/mis-compras/{order}', [OrderAdminController::class, 'showForAuthUser'])
        ->name('orders.show')
        ->middleware([
            'permission:admin_orders_auth_user_show',
            'auth.user.permission.crud.order'
        ]);

    Route::get('/pedidos', [OrderAdminController::class, 'index'])
        ->name('orders.index')
        ->middleware('permission:admin_orders_index');

    Route::get('/pedidos/{order}', [OrderAdminController::class, 'show'])
        ->name('orders.show')
        ->middleware([
            'permission:admin_orders_show',
            'auth.user.permission.crud.order'
        ]);

    //**********************************************************************//
    //********************** fin de routes Orders **************************//
    //*********************************************************************//


    //**********************************************************************//
    //********************** Routes Claims *********************************//
    //*********************************************************************//

    Route::get('/libro-de-reclamacion', [ClaimAdminController::class, 'index'])
        ->name('claims.index')
        ->middleware('permission:admin_claims_index');

    Route::get('/libro-de-reclamacion/{claim}', [ClaimAdminController::class, 'show'])
        ->name('claims.show')
        ->middleware('permission:admin_claims_show');


    //**********************************************************************//
    //********************** Fin de routes Claims **************************//
    //*********************************************************************//


    //**********************************************************************//
    //********************** Routes Contacts *******************************//
    //**********************************************************************//

    Route::get('/contactos', [ContactAdminController::class, 'index'])
        ->name('contacts.index')
        ->middleware('permission:admin_contacts_index');

    Route::get('/contactos/{contact}', [ContactAdminController::class, 'show'])
        ->name('contacts.show')
        ->middleware('permission:admin_contacts_show');


    //**********************************************************************//
    //********************** Fin de routes Contacts ************************//
    //**********************************************************************//
});
