<?php

namespace App\Http\Controllers\Auth;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Major;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;

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
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));
        $data['majors'] = Major::all();

            
        return view('auth.register', $data);
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
            'country' => [new RequiredIf(!empty($data['college_origin']))],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nrp' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'major' => ['required'],
            'phone' => ['required'],
        ], [
            'nrp.unique' => 'Your Student ID (NRP) has been registered with another email ! Please login or reset password when you forgot the password !',
            // 'country.required' => 'Country field is required !'
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
        $country = Country::whereName('Indonesia')->first();
        if (!empty($data['country']))
            $country = Country::whereId($data['country'])->first();
        
        $dataUser = [
            'country_id' => $country->id,
            'role_id' => Role::ROLES['participant'],
            'name' => $data['name'],
            'email' => $data['email'],
            'nrp' => $data['nrp'],
            'telephone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'college_origin' => empty($data['college_origin']) ? "STIKI Malang" : $data['college_origin'],
        ];
    
        if (!empty($data['custom_major'])) {
            $dataUser['custom_major'] = $data['custom_major'];
        } else {
            $dataUser['major_id'] = $data['major'];
        }
        
        return User::create($dataUser);
    }

    
    protected function registered(Request $request, $user)
    {
        Auth::logout();
        return redirect()->route('register')->withSuccess('Akun Anda berhasil dibuat! Silahkan cek inbox / spam pada email Anda untuk Aktivasi !');
    }
}
