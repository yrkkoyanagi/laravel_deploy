<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * 管理者ログイン用
     */
     public function showAdminLoginForm(){
        return view('auth.login',['authgroup' => 'admin']);
     }

    public function adminLogin(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)){
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

        if(Auth::guard('admin')->attempt(['email' => $request->email,'password' => $request->password],$request->get('remember'))){
            return redirect()->intended('/admin');
        }


        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email','remember'));
    }

}
