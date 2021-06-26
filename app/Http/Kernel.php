<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Session\Middleware\StartSession::class,//Se agrego
        \App\Http\Middleware\ForceSSL::class,//Se agrego
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
             // \Illuminate\Session\Middleware\StartSession::class,//Se comento
            // \Illuminate\Session\Middleware\AuthenticateSession::class, //Estaba comentado por defecto
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        'auth.user.permission.crud.user' => \App\Http\Middleware\User\AuthUserPermissionCrudUser::class,
        'auth.user.permission.crud.users' => \App\Http\Middleware\User\AuthUserPermissionCrudUsers::class,

        'auth.user.permission.crud.product' => \App\Http\Middleware\Product\AuthUserPermissionCrudProduct::class,
        'auth.user.permission.crud.products' => \App\Http\Middleware\Product\AuthUserPermissionCrudProducts::class,

        'auth.user.permission.crud.shipping' => \App\Http\Middleware\Shipping\AuthUserPermissionCrudShipping::class,
        'auth.user.permission.crud.shippings' => \App\Http\Middleware\Shipping\AuthUserPermissionCrudShippings::class,

        'auth.user.permission.crud.business' => \App\Http\Middleware\Business\AuthUserPermissionCrudBusiness::class,
        'check.is.auth.user.has.business' => \App\Http\Middleware\Business\CheckIsAuthUserHasBusiness::class,

        'auth.user.permission.crud.image' => \App\Http\Middleware\Image\AuthUserPermissionCrudImage::class,

        'user.permission.crud.item' => \App\Http\Middleware\Item\UserPermissionCrudItem::class,


        'order.can.change.to.paid_out' => \App\Http\Middleware\Order\CanChangeToPaidOut::class,
        'order.can.change.to.delivered' => \App\Http\Middleware\Order\CanChangeToDelivered::class,
        'order.can.change.to.cancelled' => \App\Http\Middleware\Order\CanChangeToCancelled::class,
        'order.can.change.to.failed_payment' => \App\Http\Middleware\Order\CanChangeToFailedPayment::class,

        'auth.user.permission.crud.order' => \App\Http\Middleware\Order\AuthUserPermissionCrudOrder::class,

        'auth.user.permission.crud.order.group' => \App\Http\Middleware\OrderGroup\AuthUserPermissionCrudOrderGroup::class,

    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
