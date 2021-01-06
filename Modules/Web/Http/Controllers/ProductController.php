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
		$search_product = DB::table('products')->where('title', 'like', '%'.$keywords.'%')->paginate(6);
		$search_product->appends(['keywords_submit' => $keywords]);


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
		return view('web::carts.list-cart');
	}

	public function deleteOneItem(Request $req,$id){
		$product = DB::table('products')->where('productId', $id)->first();
		if($product != null){
			$oldCart = Session('Cart') ? Session('Cart') : null;
			$newCart = new Cart($oldCart);
			$newCart->DeleteOneItem($id);
			if(Count($newCart->products) > 0){
				$req->Session()->put('Cart', $newCart);
			}
			else{
				$req->Session()->forget('Cart');
			}
		}
		return view('web::carts.list-cart');
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
			return view('web::carts.list-cart');
		}
	}

    public function product_detail($product_id, Request $request){
        $category_product = DB::table('categories')->orderby('categoryId','desc')->get();
        $product = DB::table('products')->where('productId', $product_id)->get();
        $details_product = DB::table('property_types')
            ->join('properties','property_types.propertyTypeId','=','properties.propertyTypeId')->where('properties.productId', $product_id)->get();

        foreach ($product as $pro){
            $categoryId = $pro->categoryId;
        }
        $product_same_category = DB::table('products')->where('categoryId', $categoryId)->limit(3)->get();

        return view('web::products.show_details')
            ->with('categories',$category_product)
            ->with('product_details',$details_product)
            ->with('product', $product)
            ->with('product_same_category', $product_same_category);
	}

}

?>
