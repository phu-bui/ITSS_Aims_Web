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

    public function add_category(){
        return view('admin::categories.add_category');
    }

    public function save_category(Request $request){
        $data = array();
        $data['categoryName'] = $request->category_name;
        $data['type'] = $request->category_type;

        DB::table('categories')->insert($data);
        Session::put('message', 'Add category successful!');
        return redirect()->route('admin.add_category');
    }

    public function edit_category($category_id){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $edit_category = DB::table('categories')->where('categoryId', $category_id)->get();
        return view('admin::categories.edit_category')->with('categories', $edit_category)->with('category_product', $category_product);
    }

    public function update_category(Request $request, $category_id){
        $data = array();
        $data['categoryName'] = $request->category_name;
        $data['type'] = $request->category_type;

        DB::table('categories')->where('categoryId', $category_id)->update($data);
        Session::put('message', 'Update category successful!');
        return redirect()->route('admin.edit_category', array('category_id'=>$category_id));
    }

    public function delete_category($category_id){
        DB::table('categories')->where('categoryId', $category_id)->delete();
        Session::put('message', 'Delete category successful!');
        return redirect()->route('admin.categories.list');
    }

}
