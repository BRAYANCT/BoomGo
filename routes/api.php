<?php

use App\Http\Controllers\Admin\Api\BillingInformationApiAdminController;
use App\Http\Controllers\Admin\Api\BusinessApiAdminController;
use App\Http\Controllers\Admin\Api\BusinessPaymentMethodApiAdminController;
use App\Http\Controllers\Admin\Api\CategoryApiAdminController;
use App\Http\Controllers\Admin\Api\ClaimApiAdminController;
use App\Http\Controllers\Admin\Api\ContactApiAdminController;
use App\Http\Controllers\Admin\Api\DepartmentApiAdminController;
use App\Http\Controllers\Admin\Api\DistrictApiAdminController;
use App\Http\Controllers\Admin\Api\ImageApiAdminController;
use App\Http\Controllers\Admin\Api\OrderApiAdminController;
use App\Http\Controllers\Admin\Api\ProductApiAdminController;
use App\Http\Controllers\Admin\Api\ProvinceApiAdminController;
use App\Http\Controllers\Admin\Api\ShippingApiAdminController;
use App\Http\Controllers\Admin\Api\UserApiAdminController;;

use App\Http\Controllers\Admin\PriceRangeApiAdminController;
use App\Http\Controllers\Admin\ProviderTypeApiAdminController;
use App\Http\Controllers\Api\Web\ClaimApiWebController;
use App\Http\Controllers\Api\Web\DocumentTypeApiWebController;
use App\Http\Controllers\Auth\Api\LoginApiController;
use App\Http\Controllers\Web\Api\BusinessApiWebController;
use App\Http\Controllers\Web\Api\CategoryApiWebController;
use App\Http\Controllers\Web\Api\ContactApiWebController;
use App\Http\Controllers\Web\Api\DepartmentApiWebController;
use App\Http\Controllers\Web\Api\DistrictApiWebController;
use App\Http\Controllers\Web\Api\ImageApiWebController;
use App\Http\Controllers\Web\Api\ItemApiWebController;
use App\Http\Controllers\Web\Api\OrderApiWebController;
use App\Http\Controllers\Web\Api\OrderGroupApiWebController;
use App\Http\Controllers\Web\Api\PaymentMethodApiWebController;
use App\Http\Controllers\Web\Api\ProductApiWebController;
use App\Http\Controllers\Web\Api\ProviderTypeApiWebController;
use App\Http\Controllers\Web\Api\ProvinceApiWebController;
use App\Http\Controllers\Web\Api\ReviewApiWebController;
use App\Http\Controllers\Web\Api\ShippingApiWebController;
use App\Http\Controllers\Web\Api\ShoppingCartApiWebController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//***************************************************************************************//
//********************** Routes web *****************************************************//
//***************************************************************************************//

Route::post('/login', [LoginApiController::class, 'login'])
    ->name('login');


//**********************************************************************//
//********************** Routes Categories *****************************//
//*********************************************************************//

Route::get('/categories/businesses', [CategoryApiWebController::class, 'getBusinessCategories'])
    ->name('categories.businesses.index');

Route::get('/categories/products', [CategoryApiWebController::class, 'getProductCategories'])
    ->name('categories.products.index');

    Route::get('/categories/{category}', [CategoryApiWebController::class, 'show'])
        ->name('categories.show');

//**********************************************************************//
//********************** fin de routes Categories **********************//
//*********************************************************************//


//**********************************************************************//
//********************** Routes Businesses *****************************//
//*********************************************************************//

Route::get('/businesses/recommended', [BusinessApiWebController::class, 'getAllRecommended'])
    ->name('businesses.recommended.index');

//**********************************************************************//
//********************** Fin de routes Businesses **********************//
//*********************************************************************//


//**********************************************************************//
//********************** Routes Reviews ********************************//
//*********************************************************************//

Route::get('/reviews/businesses', [ReviewApiWebController::class, 'getBusinessReviews'])
    ->name('reviews.index');

Route::get('/reviews/businesses/latest', [ReviewApiWebController::class, 'getAllBusinessLatest'])
    ->name('reviews.businesses.latest.index');

//**********************************************************************//
//********************** fin de routes Reviews *************************//
//*********************************************************************//


//**********************************************************************//
//********************** Routes Provider Types *************************//
//*********************************************************************//

Route::get('/provider-types', [ProviderTypeApiWebController::class, 'index'])
    ->name('provider_types.index');

//**********************************************************************//
//********************** fin de routes Provider Types ******************//
//*********************************************************************//



//****************************************************************//
//********************** Routes Shopping carts *******************//
//***************************************************************//

Route::post('/shopping-carts/increase-item', [ShoppingCartApiWebController::class, 'increaseItem'])
    ->name('shopping_carts.increase_item');

Route::post('/shopping-carts/decrease-item', [ShoppingCartApiWebController::class, 'decreaseItem'])
    ->name('shopping_carts.decrease_item');

Route::get('/shopping-carts/user', [ShoppingCartApiWebController::class, 'getShoppingCartUser'])
    ->name('shopping_carts.user');

//****************************************************************//
//********************** Fin de Shopping carts ******************//
//***************************************************************//


//**************************************************************//
//********************** Routes Products ***********************//
//*************************************************************//

Route::get('/products', [ProductApiWebController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductApiWebController::class, 'show'])
    ->name('products.show');

//****************************************************************//
//********************** Fin de Products *************************//
//***************************************************************//



//****************************************************************//
//********************** Routes Items ****************************//
//***************************************************************//

Route::delete('/items/{item}',[ItemApiWebController::class,'destroy'])
    ->name('items.destroy')
    ->middleware('user.permission.crud.item');

Route::post('/items/{item}/decrease-one',[ItemApiWebController::class,'decreaseOne'])
    ->name('items.decrease_one')
    ->middleware('user.permission.crud.item');

Route::post('/items/{item}/increase-one',[ItemApiWebController::class,'increaseOne'])
    ->name('items.increase_one')
    ->middleware('user.permission.crud.item');

//****************************************************************//
//********************** Fin de Routes Items **********************//
//***************************************************************//

//****************************************************************//
//********************** Routes Images ****************************//
//***************************************************************//

Route::get('/images/products/{product}', [ImageApiWebController::class, 'getAllProductImages'])
    ->name('images/products.index');

Route::get('/images/businesses/{business}', [ImageApiWebController::class, 'getAllBusinessImages'])
    ->name('images/businesses.index');

//****************************************************************//
//********************** Fin de Routes Images **********************//
//***************************************************************//

//**************************************************************//
//********************** Routes Departments ********************//
//*************************************************************//

Route::get('/departments', [DepartmentApiWebController::class, 'index'])
    ->name('departments.index');

//****************************************************************//
//********************** Fin de Departments **********************//
//***************************************************************//


//**************************************************************//
//********************** Routes Provinces **********************//
//*************************************************************//

Route::get('/provinces', [ProvinceApiWebController::class, 'index'])
    ->name('provinces.index');

//****************************************************************//
//********************** Fin de provinces ************************//
//***************************************************************//


//**************************************************************//
//********************** Routes Districts **********************//
//*************************************************************//

Route::get('/districts', [DistrictApiWebController::class, 'index'])
    ->name('districts.index');

//****************************************************************//
//********************** Fin de Districts ************************//
//***************************************************************/


//**************************************************************//
//********************** Routes Orders *************************//
//*************************************************************//

Route::post('/orders', [OrderGroupApiWebController::class, 'store'])
    ->name('orders.store');

Route::post('/orders/businesses/{business}', [OrderGroupApiWebController::class, 'storeByBusiness'])
    ->name('orders.businesses.store');

//****************************************************************//
//********************** Fin de Orders ***************************//
//***************************************************************//


//**************************************************************//
//********************** Routes Shippings **********************//
//*************************************************************//

Route::get('/shippings/shopping-cart/districts/{district}', [ShippingApiWebController::class, 'getAllForShoppingCart'])
    ->name('shippings.shopping_cart.districts');

Route::get('/shippings/businesses/{business}/districts/{district}', [ShippingApiWebController::class, 'getByBusinessAndPriorityDistrict'])
    ->name('shippings.businesses.districts');

//****************************************************************//
//********************** Fin de Shippings ************************//
//***************************************************************//


//**************************************************************//
//********************** Routes Payment Methods ****************//
//*************************************************************//

Route::get('/payment-methods/businesses-shopping-cart', [PaymentMethodApiWebController::class, 'getAllOfShoppingCartBusinesses'])
    ->name('payment_methods.businesses_shopping_cart.index');

Route::get('/payment-methods/businesses/{business}', [PaymentMethodApiWebController::class, 'getAllByBusiness'])
    ->name('payment_methods.businesses.index');

//****************************************************************//
//********************** Fin de Payment Methods ******************//
//***************************************************************//

//**************************************************************//
//********************** Routes Districts **********************//
//*************************************************************//

Route::get('/document-types', [DocumentTypeApiWebController::class, 'index'])
    ->name('document_types.index');

//****************************************************************//
//********************** Fin de Districts ***********************//
//***************************************************************/


//**************************************************************//
//********************** Routes Claims **********************//
//*************************************************************//

Route::post('/claims', [ClaimApiWebController::class, 'store'])
    ->name('claims.store');

//****************************************************************//
//********************** Fin de Claims ************************//
//****************************************************************/

//**************************************************************//
//********************** Routes Contacts ***********************//
//**************************************************************//

Route::post('/contacts', [ContactApiWebController::class, 'store'])
    ->name('contacts.store');

//****************************************************************//
//********************** Fin de Contacts *************************//
//****************************************************************//

Route::group([
    'middleware' => 'auth:api'
], function () {
    //**********************************************************************//
    //********************** Routes Reviews ********************************//
    //*********************************************************************//

//    Route::get('/post-ratings/posts/{post}/auth-user', [PostRatingApiWebController::class, 'getByPostAndAuthUser'])
//        ->name('post_ratings.posts.auth_user.show');

    Route::post('/reviews/businesses/{business}/auth-user', [ReviewApiWebController::class, 'storeByBusinessForAuthUser'])
        ->name('reviews.businesses.auth_user.rate');

    //**********************************************************************//
    //********************** fin de routes Reviews *************************//
    //*********************************************************************//

});


//***************************************************************************************//
//********************** Fin de Routes Web **********************************************//
//***************************************************************************************//


//***************************************************************************************//
//********************** Routes administrador *******************************************//
//***************************************************************************************//

Route::group([
				'as' => 'api.admin.',
				'prefix' => 'admin',
				'middleware' => 'auth:api'
			], function () {

    //*************************************************************//
    //********************** Routes Images ************************//
    //*************************************************************//

    Route::post('/images/store/editor', [ImageApiAdminController::class,'storeImageEditor'])
        ->name('images.store.editor')
        ->middleware('permission:api_admin_images_store_editor');

    Route::post('/images/store/editor-public', [ImageApiAdminController::class,'storeImageEditorPublic'])
        ->name('images.store.editor-public')
        ->middleware('permission:api_admin_images_store_editor_public');

    Route::post('/images/store/file-input', [ImageApiAdminController::class,'storeFileInput'])
        ->name('images.store.file-input');

    Route::post('/images/{image}/destroy-from-file-input',[ImageApiAdminController::class,'destroy'])
        ->name('images.destroy_from_file_input')
        ->middleware([
            'permission:api_admin_images_destroy',
            'auth.user.permission.crud.image'
        ]);

    //*************************************************************//
    //********************** Fin de routes Images *****************//
    //*************************************************************//

	//*************************************************************//
	//********************** Routes Users *************************//
	//*************************************************************//

    Route::get('/users/auth-user',[UserApiAdminController::class,'getAuthUser'])
        ->name('users.auth_user.show');

	Route::get('/users/list-table',[UserApiAdminController::class,'getListToTable'])
			->name('users.list_table.index')
			->middleware('permission:api_admin_users_list_table_index');

    Route::get('/users',[UserApiAdminController::class,'index'])
        ->name('users.index')
        ->middleware('permission:api_admin_users_index');

	Route::delete('/users/{user}',[UserApiAdminController::class,'destroy'])
			->name('users.destroy')
			->middleware([
							'permission:api_admin_users_destroy',
							'auth.user.permission.crud.user'
						]);

	Route::post('/users/destroy-by-ids',[UserApiAdminController::class,'destroyByIds'])
			->name('users.destroy_by_ids')
			->middleware([
							'permission:api_admin_users_destroy_by_ids',
							'auth.user.permission.crud.users'
						]);

	//*************************************************************//
	//********************** Fin de routes users ******************//
	//*************************************************************//

    //**************************************************************//
    //********************** Routes Businesses *********************//
    //*************************************************************//

    Route::post('/businesses/profile', [BusinessApiAdminController::class, 'storeOrUpdateForAuthUser'])
        ->name('businesses.profile.store_update')
        ->middleware('permission:api_admin_businesses_profile_store_update');

    Route::get('/businesses',[BusinessApiAdminController::class,'index'])
        ->name('businesses.index')
        ->middleware('permission:api_admin_businesses_index');

    Route::get('/businesses/list-table',[BusinessApiAdminController::class,'getListToTable'])
        ->name('businesses.list_table.index')
        ->middleware('permission:api_admin_businesses_list_table_index');

    Route::post('/businesses', [BusinessApiAdminController::class, 'store'])
        ->name('businesses.store')
        ->middleware('permission:api_admin_businesses_store');

    Route::get('/businesses/{business}', [BusinessApiAdminController::class, 'show'])
        ->name('businesses.show')
        ->middleware([
            'permission:api_admin_businesses_show',
            'auth.user.permission.crud.business'
        ]);

    Route::put('/businesses/{business}', [BusinessApiAdminController::class, 'update'])
        ->name('businesses.update')
        ->middleware([
            'permission:admin_businesses_update',
            'auth.user.permission.crud.business'
        ]);

    Route::delete('/businesses/{business}',[BusinessApiAdminController::class,'destroy'])
        ->name('businesses.destroy')
        ->middleware([
            'permission:api_admin_businesses_destroy',
            'auth.user.permission.crud.business'
        ]);

    Route::post('/businesses/destroy-by-ids',[BusinessApiAdminController::class,'destroyByIds'])
        ->name('businesses.destroy_by_ids')
        ->middleware('permission:api_admin_businesses_destroy_by_ids');

    //**************************************************************//
    //********************** Fin de routes Businesses **************//
    //*************************************************************//


    //**************************************************************//
    //********************** Routes Products ***********************//
    //*************************************************************//

//    Route::get('/products',[ProductApiAdminController::class,'index'])
//        ->name('products.index')
//        ->middleware('permission:api_admin_products_index');

    Route::get('/products/list-table',[ProductApiAdminController::class,'getListToTable'])
        ->name('products.list_table.index')
        ->middleware('permission:api_admin_products_list_table_index');

    Route::post('/products', [ProductApiAdminController::class, 'store'])
        ->name('products.store')
        ->middleware('permission:api_admin_products_store');

    Route::get('/products/{product}', [ProductApiAdminController::class, 'show'])
        ->name('products.show')
        ->middleware([
            'permission:api_admin_products_show',
            'auth.user.permission.crud.product'
        ]);

    Route::put('/products/{product}', [ProductApiAdminController::class, 'update'])
        ->name('products.update')
        ->middleware([
            'permission:admin_products_update',
            'auth.user.permission.crud.product'
        ]);

    Route::delete('/products/{product}',[ProductApiAdminController::class,'destroy'])
        ->name('products.destroy')
        ->middleware([
            'permission:api_admin_products_destroy',
            'auth.user.permission.crud.product'
        ]);

    Route::post('/products/destroy-by-ids',[ProductApiAdminController::class,'destroyByIds'])
        ->name('products.destroy_by_ids')
        ->middleware([
            'permission:api_admin_products_destroy_by_ids',
            'auth.user.permission.crud.products'
        ]);

    //**************************************************************//
    //********************** Fin de routes Products ****************//
    //*************************************************************//

    //**************************************************************//
    //********************** Routes Categories *********************//
    //*************************************************************//

    Route::get('/categories/businesses', [CategoryApiAdminController::class, 'getBusinessCategories'])
        ->name('categories.businesses.index')
        ->middleware('permission:api_admin_categories_businesses');

    Route::get('/categories/products', [CategoryApiAdminController::class, 'getProductCategories'])
        ->name('categories.products.index')
        ->middleware('permission:api_admin_categories_products');

    Route::get('/categories/category-type/{categoryType}/list-table',[CategoryApiAdminController::class,'getAllByCategoryTypeToTable'])
        ->name('categories.category_type.list_table.index')
        ->middleware('permission:api_admin_categories_list_table_index');

//    Route::post('/categories', [CategoryApiAdminController::class, 'store'])
//        ->name('categories.store');
//
//    Route::get('/categories/{category}', [CategoryApiAdminController::class, 'show'])
//        ->name('categories.show');
//
//    Route::put('/categories/{category}', [CategoryApiAdminController::class, 'update'])
//        ->name('categories.update');
//
    Route::delete('/categories/{category}',[CategoryApiAdminController::class,'destroy'])
        ->name('categories.destroy')
        ->middleware('permission:api_admin_categories_destroy');

    Route::post('/categories/destroy-by-ids',[CategoryApiAdminController::class,'destroyByIds'])
        ->name('categories.destroy_by_ids')
        ->middleware('permission:api_admin_categories_destroy_by_ids');

    //**************************************************************//
    //********************** Fin de routes Categories **************//
    //*************************************************************//


    //**************************************************************//
    //********************** Routes Departments ********************//
    //*************************************************************//

    Route::get('/departments', [DepartmentApiAdminController::class, 'index'])
        ->name('departments.index')
        ->middleware('permission:api_admin_departments_index');

    //****************************************************************//
    //********************** Fin de Departments **********************//
    //***************************************************************//


    //**************************************************************//
    //********************** Routes Provinces **********************//
    //*************************************************************//

    Route::get('/provinces', [ProvinceApiAdminController::class, 'index'])
        ->name('provinces.index')
        ->middleware('permission:api_admin_provinces_index');

    //****************************************************************//
    //********************** Fin de provinces ************************//
    //***************************************************************//


    //**************************************************************//
    //********************** Routes Districts **********************//
    //*************************************************************//

    Route::get('/districts', [DistrictApiAdminController::class, 'index'])
        ->name('districts.index')
        ->middleware('permission:api_admin_districts_index');

    //****************************************************************//
    //********************** Fin de Districts ************************//
    //****************************************************************/


    //**************************************************************//
    //********************** Routes Shippings **********************//
    //*************************************************************//

//    Route::get('/shipping', [ShippingApiAdminController::class, 'index'])
//        ->name('shipping.index')
//        ->middleware('permission:api_admin_shipping_index');


    Route::get('/shipping/list-table',[ShippingApiAdminController::class,'getListToTable'])
        ->name('shipping.list_table.index')
        ->middleware('permission:api_admin_shipping_list_table_index');

    Route::get('/shipping/{shipping}', [ShippingApiAdminController::class, 'show'])
        ->name('shipping.show')
        ->middleware([
            'permission:api_admin_shipping_show',
            'auth.user.permission.crud.shipping'
        ]);

    Route::post('/shipping', [ShippingApiAdminController::class, 'store'])
        ->name('shipping.store')
        ->middleware('permission:api_admin_shipping_store');

    Route::put('/shipping/{shipping}', [ShippingApiAdminController::class, 'update'])
        ->name('shipping.update')
        ->middleware([
            'permission:admin_shipping_update',
            'auth.user.permission.crud.shipping'
        ]);

    Route::delete('/shipping/{shipping}',[ShippingApiAdminController::class,'destroy'])
        ->name('shipping.destroy')
        ->middleware([
            'permission:api_admin_shipping_destroy',
            'auth.user.permission.crud.shipping'
        ]);

    Route::post('/shipping/destroy-by-ids',[ShippingApiAdminController::class,'destroyByIds'])
        ->name('shipping.destroy_by_ids')
        ->middleware([
            'permission:api_admin_shipping_destroy_by_ids',
            'auth.user.permission.crud.shippings'
        ]);

    //****************************************************************//
    //********************** Fin de Shippings ************************//
    //****************************************************************//


    //**************************************************************//
    //********************** Routes Price Ranges *******************//
    //*************************************************************//

    Route::get('/price-ranges', [PriceRangeApiAdminController::class, 'index'])
        ->name('price_ranges.index')
        ->middleware('permission:api_admin_price_ranges_index');

    //****************************************************************//
    //********************** Fin de Price Ranges *********************//
    //****************************************************************/


    //**************************************************************//
    //********************** Routes Provider Types *****************//
    //*************************************************************//

    Route::get('/provider-types', [ProviderTypeApiAdminController::class, 'index'])
        ->name('provider_types.index')
        ->middleware('permission:api_admin_provider_types_ranges_index');

    //****************************************************************//
    //********************** Fin de Provider Types *******************//
    //****************************************************************/

    //**************************************************************//
    //************* Routes Business Payment Method *****************//
    //*************************************************************//

    Route::get('/business-payment-method/businesses/{business}/mercado-pago', [BusinessPaymentMethodApiAdminController::class, 'getMercadoPagoByBusiness'])
        ->name('business_payment_method.businesses.mercado_pago')
        ->middleware(
            [
                'permission:api_admin_business_payment_method_businesses_mercado_pago',
                'auth.user.permission.crud.business'
            ]);

    Route::get('/business-payment-method/businesses/{business}/mercado-pago', [BusinessPaymentMethodApiAdminController::class, 'getMercadoPagoByBusiness'])
        ->name('business_payment_method.businesses.mercado_pago')
        ->middleware(
            [
                'permission:api_admin_business_payment_method_businesses_mercado_pago',
                'auth.user.permission.crud.business'
            ]);

    Route::get('/business-payment-method/businesses/{business}/wire-transfer', [BusinessPaymentMethodApiAdminController::class, 'getWireTransferByBusiness'])
        ->name('business_payment_method.businesses.wire_transfer')
        ->middleware(
            [
                'permission:api_admin_business_payment_method_businesses_wire_transfer',
                'auth.user.permission.crud.business'
            ]);

    Route::post('/business-payment-method/businesses/{business}/wire-transfer', [BusinessPaymentMethodApiAdminController::class, 'storeOrUpdateWireTransferByBusiness'])
        ->name('business_payment_method.businesses.wire_transfer.store_update')
        ->middleware([
            'permission:api_admin_business_payment_method_businesses_wire_transfer_store_update',
            'auth.user.permission.crud.business'
        ]);

    //****************************************************************//
    //************* Fin de Business Payment Method *******************//
    //****************************************************************//


    //**************************************************************//
    //********************** Routes Orders *************************//
    //*************************************************************//


    Route::post('/orders/{order}/change-to-paid-out', [OrderApiAdminController::class, 'changeToPaidOut'])
        ->name('orders.change_to_paid_out')
        ->middleware([
            'permission:api_admin_orders_change_to_paid_out',
            'auth.user.permission.crud.order',
            'order.can.change.to.paid_out',
        ]);

    Route::post('/orders/{order}/change-to-delivered', [OrderApiAdminController::class, 'changeToDelivered'])
        ->name('orders.change_to_delivered')
        ->middleware([
            'permission:api_admin_orders_change_to_delivered',
            'auth.user.permission.crud.order',
            'order.can.change.to.delivered',
        ]);

    Route::post('/orders/{order}/change-to-cancelled', [OrderApiAdminController::class, 'changeToCancelled'])
        ->name('orders.change_to_cancelled')
        ->middleware([
            'permission:api_admin_orders_change_to_cancelled',
            'auth.user.permission.crud.order',
            'order.can.change.to.cancelled',
        ]);


    Route::get('/orders/list-table',[OrderApiAdminController::class,'getListToTable'])
        ->name('orders.list_table.index')
        ->middleware('permission:api_admin_orders_list_table_index');

    Route::get('/orders/business-auth-user/list-table',[OrderApiAdminController::class,'getAllForBusinessAuthUserListToTable'])
        ->name('orders.business_auth_user.list_table.index')
        ->middleware('permission:api_admin_orders_business_auth_user_list_table_index');

    Route::get('/orders/auth-user',[OrderApiAdminController::class,'getAllForAuthUser'])
        ->name('orders.auth_user.index')
        ->middleware('permission:api_admin_orders_auth_user_index');

    //****************************************************************//
    //************* Fin de Business Orders ***************************//
    //****************************************************************//

    //*************************************************************//
    //********************** Routes Claims ************************//
    //*************************************************************//

    Route::get('/claims/list-table',[ClaimApiAdminController::class,'getListToTable'])
        ->name('claims.list_table.index')
        ->middleware('permission:api_admin_claims_list_table_index');

    //****************************************************************//
    //************* Fin de Business Claims ***************************//
    //****************************************************************//

    //*************************************************************//
    //********************** Routes Contacts **********************//
    //*************************************************************//

    Route::get('/contacts/list-table',[ContactApiAdminController::class,'getListToTable'])
        ->name('contacts.list_table.index')
        ->middleware('permission:api_admin_contacts_list_table_index');

    //****************************************************************//
    //************* Fin de Business Contacts *************************//
    //****************************************************************//

    //*************************************************************//
    //********************** Routes Billing information ***********//
    //*************************************************************//

    Route::get('/billing-information/last-one-for-auth-user',[BillingInformationApiAdminController::class,'getLastOneForAuthUser'])
        ->name('contacts.billing_information.last_one_for_auth_user.show');

    //****************************************************************//
    //************* Fin de Business Billing information **************//
    //****************************************************************//
});

//**********************************************************************//
//********************** Fin de Routes Administrador *******************//
//**********************************************************************//
