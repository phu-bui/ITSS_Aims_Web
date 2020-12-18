<?php


namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\AdminAddProductRequest;
use DB;
use mysql_xdevapi\Table;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


class UserController extends AdminBaseController
{

    public function index() {
        $users = DB::table('users')->get();
        return view('admin::users.index', compact('users'));
    }

    public function delete_user($user_id){
        DB::table('users')->where('userId', $user_id)->delete();
        Session::put('message', 'Delete user successful!');
        return redirect()->route('admin.users.list');
    }

}
