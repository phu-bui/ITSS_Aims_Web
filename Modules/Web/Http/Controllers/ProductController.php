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
        $brand_product = DB::table('brands')->orderby('id', 'desc')->get();
        $keywords = $req->keywords_submit;
		$search_product = DB::table('products')->where('name', 'like', '%'.$keywords.'%')->get();
        return view('web::products.search',compact('search_product'))->with('brand_product', $brand_product);
    }



    //shopping cart


    public function cart(Request $req) {
        return view('web::cart');
    }

	public function addCart(Request $req,$id){
		$product = DB::table('products')->where('id', $id)->first();
		if($product != null){
			$oldCart = Session('Cart') ? Session('Cart') : null;
			$newCart = new Cart($oldCart);
			$newCart->AddCart($product, $id);

			$req->Session()->put('Cart', $newCart);
		}
		return view('web::cart');
	}

	public function DeleteItemCart(Request $req,$id){
		if(Session::has("Cart") == null){
			return view('web::cart');
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
			return view('web::cart');
		}
	}

    public function product_detail($product_slug, Request $request){
        $brand_product = DB::table('brands')->orderby('id','desc')->get();
        $details_product = DB::table('products')
            ->join('brands','brands.id','=','products.brand_id')->where('products.slug', $product_slug)->get();

        foreach ($details_product as $key => $value){
            $meta_desc = $value->short_description;
            $meta_keywords = $value->slug;
            $meta_title = $value->name;
            $url_canonical = $request->url();
        }

        $related_product = DB::table('products')
            ->join('brands','brands.id','=','products.brand_id')
            ->whereNotIn('products.slug',[$product_slug])->get();
        return view('web::products.show_details')
            ->with('brand',$brand_product)
            ->with('product_details',$details_product)
            ->with('relate',$related_product)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

}

?>
