<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    use RegistersUsers {
        register as registration;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:1,2'],  // Tourist (1) or Business (2)
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
        return User::create([
            'role_id' => 3,  // Regular user
            'user_type' => $data['user_type'],  // Tourist or Business
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'passport_number' => isset($data['passport_number']) ? $data['passport_number'] : null,
            'nationality' => isset($data['nationality']) ? $data['nationality'] : null,
            'income_method' => isset($data['income_method']) ? $data['income_method'] : null,
            'income_amount' => isset($data['income_amount']) ? $data['income_amount'] : null,
            'currency_used' => isset($data['currency_used']) ? $data['currency_used'] : null,
            'planned_length_of_stay' => isset($data['planned_length_of_stay']) ? $data['planned_length_of_stay'] : null,
            'business_type' => isset($data['business_type']) ? $data['business_type'] : null,
            'business_registration_number' => isset($data['business_registration_number']) ? $data['business_registration_number'] : null,
            'business_location' => isset($data['business_location']) ? $data['business_location'] : null,
            'tax_identification_number' => isset($data['tax_identification_number']) ? $data['tax_identification_number'] : null,
            'status' => 1
        ]);

        \App\Http\Controllers\MLController::runMLPipeline();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return redirect($this->redirectPath())->with('status', 'Registration successful! Please login.');
    }
}
