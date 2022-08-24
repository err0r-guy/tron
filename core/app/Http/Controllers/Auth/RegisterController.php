<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        if (username_check($request->username)) {
            $loggedIn = new LoginController;
            return $loggedIn->login($request);
        }

        $checkWAdd = ValidateAddress($request->username);
        if ($checkWAdd['result'] == false) {
            return back()->with('error', 'Invalid tron wallet address');
        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'username' => ['required', 'string', 'min:' . settings('wallet_min'), 'max:' . settings('wallet_max'), 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ],
            [
                "username.required" => "The wallet address field is required.",
                "username.min" => "The wallet address must be at least " . settings('wallet_min') . " characters.",
                "username.max" => "The wallet address must not be greater than " . settings('wallet_max') . " characters."
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'username' => $data['username'],
        //     'password' => Hash::make($data['password']),
        // ]);

        $referBy = session()->get('reference');
        if ($referBy != null) {
            $referUser = User::where('uid', $referBy)->first();
        } else {
            $referUser = null;
        }

        // Create User
        $user = new User;
        $user->username = trim($data['username']);
        $user->uid = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        $user->ref_id = $referUser != null ? $referUser->id : null;
        $user->password = Hash::make($data['password']);
        $user->status = 1;
        $user->save();
        // Create Free Plan for User
        $plan = Plan::where('is_default', 1)->first();
        $expirationDate = Carbon::now()->addMonths($plan->period);
        $user->plans()->attach($plan->id, [
            'status' => 1,
            'expire_date' => $expirationDate
        ]);

        // User Login Log
        $ip = $_SERVER["REMOTE_ADDR"];
        $userAgent = userAgent();
        $userLogin = new UserLogin;
        $userLogin->user_id = $user->id;
        $userLogin->ip_address = $ip;
        $userLogin->agent_browser = @$userAgent['browser'];
        $userLogin->agent_os = @$userAgent['os_platform'];
        $userLogin->save();

        return $user;
    }
}
