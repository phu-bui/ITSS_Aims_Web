<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use App\Entities\Cart;
use Session;

/**
 *
 */
class ProductController extends Controller
{


    //search product
	public function search(Request $req) {
	    $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $keywords = $req->keywords_submit;
		$search_product = DB::table('products')->where('title', 'like', '%'.$keywords.'%')->get();

        return view('web::products.search',compact('search_product'))->with('category_product', $category_product);
    }



    //shopping cart


    public function cart(Request $req) {
        return view('web::carts.cart');
    }

	public function addCart(Request $req,$id){
		$product = DB::table('products')->where('productId', $id)->first();
		if($product != null){
			$oldCart = Session('Cart') ? Session('Cart') : null;
			$newCart = new Cart($oldCart);
			$newCart->AddCart($product, $id);

			$req->Session()->put('Cart', $newCart);
		}
		return view('web::carts.cart');
	}

	public function DeleteItemCart(Request $req,$id){
		if(Session::has("Cart") == null){
			return view('web::carts.cart');
		}
		else {
			$oldCart = Session('Cart') ? Session('Cart') : null;
			$newCart = new Cart($oldCart);
			$newCart->DeleteItemCart($id);
			if(Count($newCart->products) >0){
				$req->Session()->put('Cart', $newCart);
			}
			else{
				$req->Session()->forget('Cart');
			}
			return view('web::carts.cart');
		}
	}

    public function product_detail($product_id, Request $request){
        $category_product = DB::table('categories')->orderby('categoryId','desc')->get();
        $details_product = DB::table('products')
            ->join('categories','categories.categoryId','=','products.categoryId')->where('products.productId', $product_id)->get();

        foreach ($details_product as $key => $value){
            $meta_desc = $value->description;
            $meta_keywords = $value->value;
            $meta_title = $value->title;
            $url_canonical = $request->url();
        }

        $related_product = DB::table('products')
            ->join('categories','categories.categoryId','=','products.categoryId')
            ->whereNotIn('products.productId',[$product_id])->get();
        return view('web::products.show_details')
            ->with('category',$category_product)
            ->with('product_details',$details_product)
            ->with('relate',$related_product)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

}

?>
