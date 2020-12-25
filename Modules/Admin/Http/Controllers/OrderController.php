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


class OrderController extends AdminBaseController
{

    public function index() {
        $orders = DB::table('orders')->get();
        return view('admin::orders.view_order', compact('orders'));
    }

    public function delete_order($order_id){
        DB::table('orders')->where('id', $order_id)->delete();
        Session::put('message', 'Delete order successful!');
        return redirect()->route('admin.orders.list');
    }

    public function view_order($order_id){

    }

}
