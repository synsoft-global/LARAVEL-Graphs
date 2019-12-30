<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Model\storeData;
use Illuminate\Http\Request;
use Illuminate\Session;


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

    protected $setting = '';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/reports/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    protected function authenticated($user){
 
        $this->setting=storeData::whereIn('option_name',array('admin_slug_url','store_url','download_limit','store_currency','store_start_date','order_number_prefix','store_name'))->get();
        foreach($this->setting as $setting){                 
            session([$setting->option_name =>  $setting->option_value]);
        } 

          
      
    }

    /*Show login form*/
    public function loginform() {
        return view('auth.login');
        
    }

    /*logout*/
    public function logout(Request $request){           
        $request->session()->regenerate();  
        session()->flush(); 
        Auth::logout();    
        return redirect('/');
    }
}
