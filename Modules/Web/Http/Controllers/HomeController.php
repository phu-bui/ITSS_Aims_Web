<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Entities\Product;
use DB;


class HomeController extends Controller
{
    /**
     * Display a listing of the Lab09.
     * @return Renderable
     */
    public function index()
    {
        $brand_product = DB::table('brands')->orderby('id', 'desc')->get();
        $all_product = DB::table('products')->where('status', 1)->orderby('id', 'desc')->limit(4)->get();
        return view('web::home')->with('brand_product', $brand_product)->with('products', $all_product);
    }

    public function checkout() {
        return view('web::checkout');
    }

    public function searchOrder() {
        return view('web::search-order');
    }

    public function detail() {
        return view('web::products-detail');
    }

    public function aboutUs() {
        return view('web::about-us');
    }
}
