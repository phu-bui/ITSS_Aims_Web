<?php


namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\AdminAddProductRequest;
use DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Table;
use Session;
use App\Entities\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


class UserController extends AdminBaseController
{

    public function index() {
        $users = DB::table('users')->paginate(10);
        $user_total = DB::table('users')->orderby('userId', 'desc')->get();
        return view('admin::users.index', compact('users', 'user_total'));
    }

    public function delete_user($user_id){
        DB::table('users')->where('userId', $user_id)->delete();
        Session::put('message', 'Delete user successful!');
        return redirect()->route('admin.users.list');
    }

    public function edit_user($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        return view('admin::users.edit_user')->with('user', $user);
    }

    public function update_user(Request $request, $user_id){
        $data = array();
        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['role'] = $request->role;

        DB::table('users')->where('userId', $user_id)->update($data);
        Session::put('message', 'Update user successful!');
        return redirect()->route('admin.users.list');
    }

    public function add_user(){
        return view('admin::users.add_user');
    }

    public function save_user(Request $request){
        $data = array();
        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['phone'] = $request->phone;
        $data['role'] = $request->role;

        DB::table('users')->insert($data);
        Session::put('message', 'Add user successfull!');
        return redirect()->route('admin.users.list');
    }

    public function update_password($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        return view('admin::users.update_password')->with('user', $user);
    }

    public function save_update_password(Request $request, $user_id){
        $password = $request->user_password;
        $user = User::where('userId', $user_id)->first();

        if (!(Hash::check($password, $user->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");

        }
        $user_update = array();
        $user_update['password'] = Hash::make($request->user_new_password);
        DB::table('users')->where('userId', $user_id)->update($user_update);
        $user = DB::table('users')->where('userId', $user_id)->get();
        Session::put('message', 'Update password successful!');
        return view('admin::users.update_password')->with('user', $user);
    }

}
