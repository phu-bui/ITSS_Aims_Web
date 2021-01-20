<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use DB;
class AdminController extends AdminBaseController
{
    /**
     * Display a listing of the Lab09.
     * @return Renderable
     */
    public function index()
    {
        $products = DB::table('products')->orderby('productId', 'desc')->get();
        $users = DB::table('users')->orderby('userId', 'desc')->get();
        $categories = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $orders = DB::table('orders')->orderby('id', 'desc')->get();
        return view('admin::dashboard.index')
            ->with('products', $products)
            ->with('users', $users)
            ->with('categories', $categories)
            ->with('orders', $orders);
    }


}
