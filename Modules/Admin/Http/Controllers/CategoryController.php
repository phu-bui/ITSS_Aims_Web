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

class CategoryController extends AdminBaseController
{
    public function index() {
        $categories = DB::table('categories')->get();
        return view('admin::categories.index', compact('categories'));
    }

}
