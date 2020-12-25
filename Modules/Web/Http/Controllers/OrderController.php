<?php


namespace Modules\Web\Http\Controllers;
use App\Entities\Cart;
use App\OrderDetails;
use App\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
session_start();

class OrderController extends Controller
{
    public function order_history(){
        if (session()->has('data-signin')) {
            $user = \App\Entities\User::where('email', session('data-signin')['email'])->first();
            $orders = DB::table('orders')->where('userId', $user->userId)->get();
            return view('web::orders.order_history')->with('orders', $orders);
        }
        else{
            return view('web::error.404');
        }

    }

    public function order_cancellation($ordered_id){
        $ordered_detail = DB::table('orderDetails')->where('orderId', $ordered_id)->get();
        $ordered = DB::table('orders')->where('id', $ordered_id)->get();
        foreach ($ordered_detail as $item){
            $product_id = $item->productId;
            $quantity = $item->quantity;
        }

        $product_ordered = DB::table('products')->where('productId', $product_id)->get();
        foreach ($product_ordered as $item) {
            $quantity_updated = $item->quantity + $quantity;
        }
        DB::table('products')->where('productId', $product_id)->update(['quantity'=>$quantity_updated]);

        foreach ($ordered as $item){
            DB::table('orders')->where('id', $ordered_id)->update(['orderStatus'=>0]);
        }

        return redirect()->route('web.order_history');
    }

    public function view_ordered($ordered_id){

    }
}
