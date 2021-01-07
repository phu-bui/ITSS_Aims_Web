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


class HistoryController extends AdminBaseController
{

    public function index() {
        // $adminHistory = DB::table('historyadmins')->paginate(10);
        $adminHistory = DB::table('historyadmins')->join('admins', 'historyadmins.adminId', '=', 'admins.id')->paginate(10);
        return view('admin::history.index', compact('adminHistory'));
    }

}
