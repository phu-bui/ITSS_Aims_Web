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
            $orders = DB::table('orders')->where('userId', $user->userId)->paginate(5);
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

        foreach ($ordered as $order){
            DB::table('orders')->where('id', $ordered_id)->update(['orderStatus'=>0]);
            $payment_id = $order->paymentId;
            $total_price = $order->totalPrices;
        }
        $payment_info = DB::table('payments')->join('payment_methods', 'payments.paymentMethodId', '=', 'payment_methods.paymentMethodId')->where('payments.paymentId', $payment_id)->get();
        foreach ($payment_info as $item){
            $payment_method_name = $item->paymentName;
        }
        if($payment_method_name == 'handcash'){
            return redirect()->route('web.order_history');
        }
        else {
            //update  paypal money
            $payment = DB::table('payments')->where('paymentId', $payment_id)->get();
            foreach ($payment as $item) {
                $payment_money = $item->paymentMoney;
            }
            $payment_money += $total_price;
            DB::table('payments')->where('paymentId', $payment_id)->update(['paymentMoney' => $payment_money]);

            return redirect()->route('web.order_history');
        }
    }

    public function view_order_detail($ordered_id){
        $ordered = DB::table('orders')->join('payments', 'orders.paymentId', '=', 'payments.paymentId')->where('orders.id', $ordered_id)->get();
        foreach ($ordered as $order) {
            $payment_id = $order->paymentId;
        }
        $payment_method = DB::table('payment_methods')->join('payments', 'payment_methods.paymentMethodId', '=', 'payments.paymentMethodId')->where('payments.paymentId', $payment_id)->get();

        $product_ordered = DB::table('products')->join('orderDetails','products.productId', '=', 'orderDetails.productId')->where('orderDetails.orderId', $ordered_id)->get();
        $shipping = DB::table('ships')->join('orders', 'ships.shipId', '=', 'orders.shipId')->where('orders.id', $ordered_id)->get();
        return view('web::orders.view_ordered')
            ->with('ordered', $ordered)->with('shipping', $shipping)->with('product_ordered', $product_ordered)->with('payment_method', $payment_method);
    }
}
