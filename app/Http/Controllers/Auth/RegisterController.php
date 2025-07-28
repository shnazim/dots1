<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Utilities\Overrider;
use Illuminate\Foundation\Auth\RegistersUsers;
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
        Overrider::load("Settings");
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (get_option('member_signup') != 1) {
            return back();
        }

        if (get_option('affiliate_status', 0) == 1 && request()->has('ref')) {
            session(['referrer' => request()->query('ref')]);
        }

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        config(['recaptchav3.sitekey' => get_option('recaptcha_site_key')]);
        config(['recaptchav3.secret' => get_option('recaptcha_secret_key')]);

        return Validator::make($data, [
            'name'                 => ['required', 'string', 'max:50'],
            'email'                => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'country_code'         => ['required'],
            'mobile'               => ['required', 'numeric', 'unique:users,phone'],
            'password'             => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => get_option('enable_recaptcha', 0) == 1 ? 'required|recaptchav3:register,0.5' : '',
        ], [
            //'agree.required'                   => _lang('You must agree with our privacy policy and terms of use'),
            'g-recaptcha-response.recaptchav3' => _lang('Recaptcha error!'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $affiliate_status = get_option('affiliate_status', 0);
        $referrer         = User::where('referral_token', session()->pull('referrer'))->whereNotNull('referral_token')->first();

        $user = User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'phone'           => $data['country_code'] . $data['mobile'],
            'user_type'       => 'user',
            'status'          => 1,
            'package_id'      => isset($data['package_id']) ? $data['package_id'] : null,
            'profile_picture' => 'default.png',
            'password'        => Hash::make($data['password']),
            'referrer_id'     => $referrer && $affiliate_status == 1 ? $referrer->id : null,
            'referral_token'  => generate_referral_token(),
        ]);

        return $user;
    }
}
