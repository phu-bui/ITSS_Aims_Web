<?php

namespace Modules\Web\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Services\Utils\AuthUtils;
use App\Entities\User;
use DB;
use Session;
class LoginController extends BaseController
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function showLoginForm()
    {
        if(session()->has('data-signin')){
            return redirect()->route('web.home');
        }
        return view('web::login');
    }

    public function login(Request $request) {
        $rules = [
            'email' =>'required|email',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('email', $email)->first();
            if(!empty($user) && AuthUtils::attemptLogin($user, 'web', $email, $password, $request->has('remember_me'))){
                $request->session()->put('data-signin', $request->input());
                return redirect()->route('web.home');
            } else {
                return redirect()->back()->withErrors(['email' => 'Email or password incorrect !'])->withInput();
            }
        }
    }

    public function logout(Request $request)
    {
        if(session()->has('data-signin')){
            session()->forget('data-signin');
            return redirect()->route('web.home');
        }
        else{
            return redirect()->route('web.login');
        }

    }

    public function view_account($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        return view('web::users.view_account')->with('user', $user);
    }

    public function update_profile(Request $request, $user_id){
        $data_profile = array();
        $data_profile['name'] = $request->user_name;
        $data_profile['email'] = $request->user_email;
        $data_profile['phone'] = $request->user_phone;

        DB::table('users')->where('userId', $user_id)->update($data_profile);
        Session::put('message', 'Update profile successful!');
        return redirect()->route('web.profile', array('user_id'=>$user_id));
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
