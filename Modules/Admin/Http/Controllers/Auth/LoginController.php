<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Entities\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Services\Utils\AuthUtils;
use DB;
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
        return view('admin::auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $adminUser = Admin::where('email', $email)->first();
        if(empty($adminUser)) {
            return redirect()->back()->withErrors(['email' => 'Email incorrect !'])->withInput();
        } else if (!AuthUtils::attemptLogin($adminUser, 'admin', $email, $password)){

            return redirect()->back()->withErrors(['password' => 'Password incorrect !'])->withInput();
        }
        $request->session()->put('admin-data-signin', $request->input());
        return redirect()->route('admin.index');
    }

    public function profile(){
        if (session()->has('admin-data-signin')) {
            $admin = DB::table('admins')->where('email', session('admin-data-signin')['email'])->first();
        }
        $admin_id = $admin->id;
        $admin_info = DB::table('admins')->where('id', $admin_id)->get();
        return view('admin::auth.profile')->with('admin_info', $admin_info);
    }

    public function logout(Request $request)
    {
        session()->forget('admin-data-signin');
        $this->guard()->logout();

        return redirect()->route('admin.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
