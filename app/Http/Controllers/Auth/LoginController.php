<?php

namespace App\Http\Controllers\Auth;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;


    public function showLoginForm()
    {
        if (!empty(session('error_msg')))
            Alert::error('Gagal !', session('error_msg'));
        if (!empty(session('success')))
            Alert::success('Success !', session('success'));

        return view('auth.login');
    }

    protected function sendFailedLoginResponse($data)
    {
        $err = [];
        if ($data['verified'] === false) {
            $err['username'] = [trans('auth.inverified')];
        } else {
            $err['username'] = [trans('auth.failed')];
        }

        throw ValidationException::withMessages($err);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $valid = Auth::attempt($credentials);

        if ($valid) {
            $user = $this->guard()->user();
            if ($user->role_id == Role::ROLES['participant']) {
                if(!$user->hasVerifiedEmail()){
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    return $this->sendFailedLoginResponse(['verified' => false]);
                }
            }
        }
        return $valid;
    }

    protected function sendLoginResponse(Request $request)
    {
        /* if (Auth::user()->role_id != Role::ROLES['participant'])
            return redirect()->route('backsite.dashboard.index');
        else */
        return redirect()->route('backsite.dashboard.index');

        // return redirect()->route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
