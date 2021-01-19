<?php


namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\UserCRUDRequest;
use App\Http\Requests\AdminAddProductRequest;
use DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Table;
use Session;
use App\Entities\User;
use Illuminate\Support\Facades\Mail;
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
        $user = DB::table('users')->where('userId', $user_id)->get();
        DB::table('users')->where('userId', $user_id)->delete();
        $data = array();
        foreach ($user as $us){
            $data['name'] = $us->name;
            $data['email'] = $us->email;
        }
        //send mail
        Mail::send(['text'=>'admin::users.mail'], array('name'=>$data['name'], 'email'=>$data['email']), function($message) use($data){
            $message->to($data['email'], $data['name'])->subject('Your account information has been deleted');
            $message->from('phubuihedspi@gmail.com','Aims System');
        });

        Session::put('message', 'Delete user successful!');
        return redirect()->route('admin.users.list');
    }

    public function edit_user($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        return view('admin::users.edit_user')->with('user', $user);
    }

    public function update_user(UserCRUDRequest $request, $user_id){
        $data = array();
        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['role'] = $request->role;

        DB::table('users')->where('userId', $user_id)->update($data);
        Mail::send(['text'=>'admin::users.mail'], array('name'=>$data['name'], 'email'=>$data['email']), function($message) use($data){
            $message->to($data['email'], $data['name'])->subject('Your account information has been updated');
            $message->from('phubuihedspi@gmail.com','Aims System');
        });

        Session::put('message', 'Update user successful!');
        return redirect()->route('admin.users.list');
    }

    public function add_user(){
        return view('admin::users.add_user');
    }

    public function save_user(UserCRUDRequest $request){
        $data = array();
        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['phone'] = $request->phone;
        $data['role'] = $request->role;

        DB::table('users')->insert($data);

        Mail::send(['text'=>'admin::users.mail'], array('name'=>$data['name'], 'email'=>$data['email']), function($message) use($data){
            $message->to($data['email'], $data['name'])->subject('Your aims app account has been created');
            $message->from('phubuihedspi@gmail.com','Aims System');
        });

        Session::put('message', 'Add user successfugit l!');
        return redirect()->route('admin.users.list');
    }

    public function update_password($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        return view('admin::users.update_password')->with('user', $user);
    }

    public function save_update_password(UserCRUDRequest $request, $user_id){
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

    public function block_user($user_id){

        $user = DB::table('users')->where('userId', $user_id)->get();
        $data = array();
        foreach ($user as $us){
            $data['name'] = $us->name;
            $data['email'] = $us->email;
        }

        DB::table('users')->where('userId', $user_id)->update(['role'=>1]);

        Mail::send(['text'=>'admin::users.mail'], array('name'=>$data['name'], 'email'=>$data['email']), function($message) use($data){
            $message->to($data['email'], $data['name'])->subject('Your account information has been blocked');
            $message->from('phubuihedspi@gmail.com','Aims System');
        });

        Session::put('message', 'Block user successful!');

        return redirect()->route('admin.users.list');
    }

    public function unblock_user($user_id){
        $user = DB::table('users')->where('userId', $user_id)->get();
        $data = array();
        foreach ($user as $us){
            $data['name'] = $us->name;
            $data['email'] = $us->email;
        }

        DB::table('users')->where('userId', $user_id)->update(['role'=>0]);

        Mail::send(['text'=>'admin::users.mail'], array('name'=>$data['name'], 'email'=>$data['email']), function($message) use($data){
            $message->to($data['email'], $data['name'])->subject('Your account information has been unblocked');
            $message->from('phubuihedspi@gmail.com','Aims System');
        });

        Session::put('message', 'Unblock user successful!');

        return redirect()->route('admin.users.list');
    }

}
