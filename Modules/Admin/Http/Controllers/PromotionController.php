<?php


namespace Modules\Admin\Http\Controllers;


use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use App\Entities\Admin;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\PromotionCRUDRequest;
use DB;
use Modules\Admin\Http\Requests\ProductCRUDRequest;
use mysql_xdevapi\Table;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


class PromotionController extends AdminBaseController
{

    public function index() {
        $promotions = DB::table('promotions')->paginate(8);
        $categories = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $promotions_total = DB::table('promotions')->orderby('promotionId', 'desc')->get();
        return view('admin::promotions.index', compact('promotions','categories', 'promotions_total'));
    }

    public function add_promotion(){
        return view('admin::promotions.add_promotion')->with('category_product');
    }

    public function save_promotion(PromotionCRUDRequest $request){
        $data = array();
        $data['type'] = $request->type;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['discount'] = $request->discount;
        $data['num_product_discount'] = $request->number;
        $data['start_at'] = $request->start_at;
        $data['end_at'] = $request->end_at;


        $promotion_new_id = DB::table('promotions')->insertGetId($data);
        Session::put('message', 'Add promotion successful!');

        return redirect()->route('admin.promotions.list');
    }

    public function edit_promotion($promotion_id){
        $edit_promotion = DB::table('promotions')->where('promotionId', $promotion_id)->get();
        return view('admin::promotions.edit_promotion')->with('promotions', $edit_promotion);
    }

    public function update_promotion(ProductCRUDRequest $request, $promotion_id){
        $data = array();
        $data['type'] = $request->type;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['discount'] = $request->discount;
        $data['num_product_discount'] = $request->number;
        $data['start_at'] = $request->start_at;
        $data['end_at'] = $request->end_at;

        DB::table('promotions')->where('promotionId', $promotion_id)->update($data);
        Session::put('message', 'Update promotion successful!');

        return redirect()->route('admin.promotions.list');
    }

    public function delete_promotion($promotion_id){
        $promotion = DB::table('promotions')->where('promotionId', $promotion_id)->get();
        foreach ($promotion as $promo){
            $category_discount = $promo->category_id;
            $discount = $promo->discount;
        }
        $tile = 1 - $discount/100;
        $products = DB::table('products')->where('categoryId', $category_discount)->get();
        foreach ($products as $product){
            $product_price = $product->price/$tile;
            Db::table('products')->where('productId', $product->productId)->update(['price'=>$product_price]);
        }
        DB::table('promotions')->where('promotionId', $promotion_id)->delete();
        return redirect()->route('admin.promotions.list');
    }

    public function add_product_to_promotion($promotion_id){
        $promotion = DB::table('promotions')->where('promotionId', $promotion_id)->get();
        $categories = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $products = DB::table('products')->orderby('productId', 'desc')->get();
        return view('admin::promotions.add_product_to_promotion')
            ->with('products', $products)
            ->with('promotions', $promotion)
            ->with('category_product', $categories);
    }

    public function save_add_product_to_promotion(Request $request, $promotion_id){
        $promotion = DB::table('promotions')->where('promotionId', $promotion_id)->get();
        foreach ($promotion as $promo) {
            $discount = $promo->discount;
            $num_product_discount = $promo->num_product_discount;
        }
        $category_id = $request->categoryId;

        $products = DB::table('products')->where('categoryId', $category_id)->get();
        $num_product = count($products);

        if($num_product<=$num_product_discount){
            DB::table('promotions')->where('promotionId', $promotion_id)->update(['category_id'=>$category_id]);
            foreach ($products as $product){
                $product_price_new = $product->price*(1-$discount/100);
                DB::table('products')->where('productId', $product->productId)->update(['price'=>$product_price_new]);
            }

            Session::put('message', 'Start promotion successful!');
            return redirect()->route('admin.promotions.list');
        }
        else{
            Session::put('message', 'Sorry, Start up failed! Number of products exceeded');
            return redirect()->route('admin.add_product_to_promotion', array('promotion_id'=>$promotion_id));
        }
    }
}
