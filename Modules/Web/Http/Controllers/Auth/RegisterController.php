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
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
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

    public function register(Request $request) {
        $rules = [
            'email' =>'required|email',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $data = array();
            $data['name'] = $request->input('name');
            $data['email'] = $request->input('email');
            $data['password'] = Hash::make($request->input('password'));
            DB::table('users')->insert($data);
            Session::put('message', 'Thành công');
            return redirect()->back();
        }
    }
}
