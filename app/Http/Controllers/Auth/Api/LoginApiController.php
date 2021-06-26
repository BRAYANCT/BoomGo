<?php

namespace App\Http\Controllers\Auth\Api;

use App\Services\ShoppingCartServiceImpl;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    private $shoppingCartService;

    public function __construct()
    {
        $this->shoppingCartService = new ShoppingCartServiceImpl();
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
        $data = array();
        $message = array();
        $hasError = false;
        $codeResponse = 200;

        try {
            $shoppingCartToken = $request->cookie(config('constant.shoppingcart.name_cookie'));
            $this->shoppingCartService->moveShoppingCartCookieToAuthUser($shoppingCartToken);
        }catch(\Exception $e){
            report($e);
        }


        array_push($message,'Inicio de sesión exitoso');

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
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
    protected function attemptLogin(Request $request){
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
            if($user-> fk_estUsuario != 1){
                $message = trans('auth.disable');
            }
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }


}
