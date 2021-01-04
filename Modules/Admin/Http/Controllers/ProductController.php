<?php


namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\BaseController;
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
        return view('admin::products.index', compact('products'));
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
            $property_id = $item->id;

            $data['productId'] = $product_id;
            $data['propertyTypeId'] = $item->id;
            $data['value'] = $request->$property_id;

            DB::table('properties')->insert($data);
        }
        Session::put('message', 'Add product successful!');
        return redirect()->route('admin.add_product');

    }

    public function renderPropertyForm(Request $request) {
        if($request->ajax()) {
            $categoryId = $request->get('category_id');
            $oldDatas = $request->get('old_data');
            $propertyTypes = DB::table('property_types')->where('categoryId', $categoryId)->get();
            $propertyForm = view('admin::products.property-form', compact('propertyTypes', 'oldDatas'))->render();
            return response()->json(compact('propertyForm'));
        } else {
            return response()->json([]);
        }
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
        DB::table('properties')->where('productId', $product_id)->delete();
        Session::put('message', 'Delete product successful!');
        return redirect()->route('admin.products.list');
    }

}
