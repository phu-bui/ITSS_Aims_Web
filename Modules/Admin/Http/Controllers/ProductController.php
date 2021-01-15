<?php


namespace Modules\Admin\Http\Controllers;


use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use App\Entities\Admin;
use App\Entities\ListDeleteProduct;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use DB;
use Modules\Admin\Http\Requests\ProductCRUDRequest;
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
        $products = DB::table('products')->paginate(8);
        $categories = DB::table('categories')->orderby('categoryId', 'desc')->get();
        return view('admin::products.index', compact('products','categories'));
    }

    public function add_product(){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();

        return view('admin::products.add_product')->with('category_product', $category_product);
    }

    public function save_product(ProductCRUDRequest $request){
        $data = array();
        $data['categoryId'] = $request->categoryId;
        $data['idGood'] = 1;
        $data['title'] = $request->title;
        $data['value'] = $request->value;
        $data['image'] = $request->image;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $data['language'] = $request->language;

        $product_new_id = DB::table('products')->insertGetId($data);

        $propertyTypes = DB::table('property_types')->where('categoryId', $request->categoryId)->get();


        if (session()->has('admin-data-signin')) {
            $admin = DB::table('admins')->where('email', session('admin-data-signin')['email'])->first();
        }
        $admin_id = $admin->id;
        $mytime = Carbon::now();
        DB::insert('insert into historyadmins (adminId, act, createDate, productId) values (?, ?, ?, ?)', [$admin_id, 'Add', $mytime,$product_new_id]);

        return view('admin::products.add_property')->with('propertyTypes', $propertyTypes)->with('product_new_id', $product_new_id)
            ->with('categoryId', $request->categoryId);
    }

    public function add_property(Request $request, $category_id) {
        $property_type = DB::table('property_types')->where('categoryId', $category_id)->get();
        $product_new = DB::table('products')->orderby('productId', 'desc')->limit(1)->get();
        foreach ($product_new as $product) {
            $product_id = $product->productId;
        }
        foreach ($property_type as $item) {
            $data = array();
            $property_id = $item->propertyTypeId;

            $data['productId'] = $product_id;
            $data['propertyTypeId'] = $item->propertyTypeId;
            $data['value'] = $request->$property_id;

            DB::table('properties')->insert($data);
        }
        Session::put('message', 'Add product successful!');
        return redirect()->route('admin.add_product');

    }

    public function edit_product($product_id){
        $category_product = DB::table('categories')->join('products', 'categories.categoryId', '=', 'products.categoryId')->where('products.productId', $product_id)->get();
        $edit_product = DB::table('products')->where('productId', $product_id)->get();
        return view('admin::products.edit_product')->with('products', $edit_product)->with('category_product', $category_product);
    }

    public function update_product(ProductCRUDRequest $request, $product_id){
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
        $properties = DB::table('properties')->join('property_types', 'properties.propertyTypeId', '=', 'property_types.propertyTypeId')->where('properties.productId', $product_id)->get();
        if (session()->has('admin-data-signin')) {
            $admin = DB::table('admins')->where('email', session('data-signin')['email'])->first();
        }
        $admin_id = $admin->id;
        $mytime = Carbon::now();
        DB::insert('insert into historyadmins (adminId, act, createDate, productId) values (?, ?, ?, ?)', [$admin_id, 'Edit', $mytime,$product_id]);
        return view('admin::products.update_property')
            ->with('properties', $properties)
            ->with('product_id', $product_id)
            ->with('categoryId', $request->category_id);
    }

    public function update_property(Request $request, $product_id) {
        $product = DB::table('products')->where('productId', $product_id)->get();
        foreach ($product as $pro){
            $category_id = $pro->categoryId;
        }
        $property_type = DB::table('property_types')->where('categoryId', $category_id)->get();
        foreach ($property_type as $item) {
            $data = array();
            $property_id = $item->id;
            $data['value'] = $request->$property_id;
            DB::table('properties')->where('productId', $product_id)->where('propertyTypeId', $item->id)->update($data);
        }
        Session::put('message', 'Update product successful!');
        return redirect()->route('admin.products.list');

    }

    public function delete_product($product_id){
        DB::table('products')->where('productId', $product_id)->delete();
        DB::table('properties')->where('productId', $product_id)->delete();
        Session::put('message', 'Delete product successful!');
        if (session()->has('admin-data-signin')) {
            $admin = DB::table('admins')->where('email', session('admin-data-signin')['email'])->first();
        }
        $admin_id = $admin->id;
        $mytime = Carbon::now();
        DB::insert('insert into historyadmins (adminId, act, createDate, productId) values (?, ?, ?, ?)', [$admin_id, 'Delete', $mytime,$product_id]);
        return redirect()->route('admin.products.list');
    }

    public function delete_list_product(Request $rq){
        $listProducts = $rq->favorite;
            foreach ($listProducts as $product_id) {
            DB::table('products')->where('productId', $product_id)->delete();
            DB::table('properties')->where('productId', $product_id)->delete();
            if (session()->has('admin-data-signin')) {
                $admin = DB::table('admins')->where('email', session('admin-data-signin')['email'])->first();
            }
            $admin_id = $admin->id;
            $mytime = Carbon::now();
            DB::insert('insert into historyadmins (adminId, act, createDate, productId) values (?, ?, ?, ?)', [$admin_id, 'Delete', $mytime,$product_id]);
            }
            Session::put('message', 'Delete product successful!');
            return ;
    }


    public function show_category_home($cate_name){
        $categories = DB::table('categories')->orderby('categoryId','desc')->get();

        $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->paginate(8);

        $category_name = DB::table('categories')->where('categories.categoryName',$cate_name)->limit(1)->get();

        return view('admin::products.show_category')->with('categories', $categories)
            ->with('product_by_category', $product_by_category)
            ->with('category_name', $category_name);
    }

}
