<?php


namespace Modules\Web\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

class CategoryController extends WebBaseController
{
    public function show_category_home($cate_name, Request $request){
        $categories = DB::table('categories')->orderby('categoryId','desc')->get();
        $category_name = DB::table('categories')->where('categories.categoryName',$cate_name)->limit(1)->get();
        if($request->orderby){
            $orderby =$request->orderby;
            switch ($orderby) {
                case 'desc':
                    $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->orderBy('productId' , 'DESC')->paginate(6);
                    break;

                case 'asc':
                    $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->orderBy('productId' , 'ASC')->paginate(6);
                    break;
                case 'price_max':
                    $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->orderBy('price' , 'DESC')->paginate(6);
                    break;
                case 'price_min':
                    $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->orderBy('price' , 'ASC')->paginate(6);
                    break;
                default:
                    $product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->orderBy('productId' , 'DESC')->paginate(6);
                    break;
            }
        }
        else 
        {
        	$product_by_category = DB::table('products')->join('categories','products.categoryId','=','categories.categoryId')->where('categories.categoryName',$cate_name)->paginate(6);
        }
        return view('web::categories.show_category')->with('categories', $categories)
            ->with('product_by_category', $product_by_category)
            ->with('category_name', $category_name);
    }

}
