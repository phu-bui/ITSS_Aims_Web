<?php


namespace Modules\Web\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

class CategoryController extends WebBaseController
{
    public function show_category_home($cate_name){
        $categories = DB::table('categories')->orderby('categoryId','desc')->get();

        $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->get();

        $category_name = DB::table('categories')->where('categories.categoryName',$cate_name)->limit(1)->get();

        return view('web::categories.show_category')->with('categories', $categories)
            ->with('product_by_category', $product_by_category)
            ->with('category_name', $category_name);
    }

}
