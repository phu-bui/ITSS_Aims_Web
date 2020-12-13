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


class ProductController extends AdminBaseController
{
    protected $productService;

    public function __construct(ProductService $productService) {
        parent::__construct();

        $this->productService = $productService;
    }

    public function index() {
        $products = DB::table('products')->get();
        return view('admin::products.index', compact('products'));
    }

    public function add_product(){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();

        return view('admin::products.add_product')->with('category_product', $category_product);
    }

    public function save_product(Request $request){
        $data = array();
        $data['categoryId'] = $request->category_id;
        $data['idGood'] = 1;
        $data['title'] = $request->title;
        $data['value'] = $request->value;
        $data['image'] = $request->image;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $data['language'] = $request->language;

        DB::table('products')->insert($data);
        Session::put('message', 'Add product successful!');
        return redirect()->route('admin.add_product');
    }

    public function edit_product($product_id){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $edit_product = DB::table('products')->where('productId', $product_id)->get();
        return view('admin::products.edit_product')->with('products', $edit_product)->with('category_product', $category_product);
    }

    public function update_product(Request $request, $product_id){
        $data = array();
        $data['categoryId'] = $request->category_id;
        $data['idGood'] = 1;
        $data['title'] = $request->title;
        $data['value'] = $request->value;
        $data['image'] = $request->image;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $data['language'] = $request->language;

        DB::table('products')->where('productId', $product_id)->update($data);
        Session::put('message', 'Update product successful!');
        return redirect()->route('admin.edit_product', array('product_id'=>$product_id));
    }
    public function delete_product($product_id){
        DB::table('products')->where('productId', $product_id)->delete();
        Session::put('message', 'Delete product successful!');
        return redirect()->route('admin.products.list');
    }

}
