<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ShoppingCartServiceImpl;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $fieldNameLogin = "";

    private $shoppingCartService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->shoppingCartService = new ShoppingCartServiceImpl();
    }


        /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $title = "Inicio de sesión";
        return view('auth.login',compact('title'));
    }


    protected function credentials(Request $request)
    {

        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        $this-> fieldNameLogin = $field;

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

     /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge($this->credentials($request),['user_state_id'=>1]);
        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this-> fieldNameLogin,$request->input($this->username()))->first();

        $message = trans('auth.failed');
        if($user){
            if($user-> user_state_id != 1){
                $message = trans('auth.disable');
            }
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            $shoppingCartToken = $request->cookie(config('constant.shoppingcart.name_cookie'));
            $this->shoppingCartService->moveShoppingCartCookieToAuthUser($shoppingCartToken);
        }catch(\Exception $e){
            report($e);
        }
    }


    public function redirectPath()
    {
        // \Log::debug('LoginController redirectPath');

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        $authUser = Auth::user();

        $this-> redirectTo = $authUser-> getFirstPageAuth();

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';

    }



    public function logout(Request $request)
    {

        $logOutPage = "/";

        $authUser = Auth::user();

        if($authUser){
            //obtiene el url de logout
            $logOutPage = $authUser->getLogOutPage();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect($logOutPage);
    }
}
