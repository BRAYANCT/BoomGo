<?php

namespace App\Http\Controllers\Auth;

use App\Rules\AlphaSpacesRule;
use App\Services\ShoppingCartServiceImpl;
use App\Services\UserServiceImpl;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $userService;
    private $shoppingCartService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->userService = new UserServiceImpl();
        $this->shoppingCartService = new ShoppingCartServiceImpl();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'names' => [
                'required',
                new AlphaSpacesRule,
                'max:'.config('constant.attribute.names.max')
            ],
            'surnames' => [
                'required',
                new AlphaSpacesRule,
                'max:'.config('constant.attribute.surnames.max')
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,NULL,id',
                'max:'.config('constant.attribute.email.max')
            ],
            'password' => ['required', 'string', 'min:'.config('constant.attribute.password.min'),'regex:'.config('constant.attribute.password.regex') , 'confirmed'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        $user = $this-> userService->createFromPublicForm($data);

        try {
//            $when = now()->addSeconds(10);
//            $user->notify((new UserWelcomeNotification())->delay($when));
        }catch (\Exception $e) {
            report($e);
        }

        return $user;
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $title = "Registro de usuario";
        $description = "";
        return view('auth.register',compact('title','description'));
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
//        Log::debug('registered');
        try {

            $shoppingCartToken = $request->cookie(config('constant.shoppingcart.name_cookie'));
            Log::debug("shoppingCartToken".$shoppingCartToken);
            $this->shoppingCartService->moveShoppingCartCookieToAuthUser($shoppingCartToken);
        }catch(\Exception $e){
            report($e);
        }

        $route = $user->getFirstPageAuth();
        return redirect($route);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}
