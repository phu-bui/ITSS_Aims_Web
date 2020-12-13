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

class CheckoutController extends Controller
{
    public function login_checkout(){
        $brand_product = DB::table('brands')->orderby('id', 'desc')->get();

        return view('web::checkout.login_checkout')->with('brand_product', $brand_product);
    }

    public function checkout(Request $request){
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();

        $brand_product = DB::table('brands')->orderby('id', 'desc')->get();

        return view('web::checkout.show_checkout')
            ->with('brand_product', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }

    public function save_checkout_customer(Request $requests){
        $data = array();
        $data['name'] = $requests->shipping_name;
        $data['phone'] = $requests->shipping_phone;
        $data['email'] = $requests->shipping_email;
        $data['address'] = $requests->shipping_address;
        $data['notes'] = $requests->shipping_notes;

        $shipping_id = DB::table('shipping_types')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return redirect()->route('web.payment');

    }

    public function payment(Request $request){
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        $brand_product = DB::table('brands')->orderby('id', 'desc')->get();

        return view('web::checkout.payment')->with('brand_product', $brand_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }

    public function order_place(Request $request){
        //insert payment
        $data = array();
        $data['name'] = $request->payment_option;
        $data['visible'] = 'Thanh cong';
        if($data['name'] == null){
            Session::put('message', 'Sorry, Please choose your form of payment!');
            return view('web::checkout.payment');
        }
        else {
            $payment_id = DB::table('payment_types')->insertGetId($data);


            //insert order

            if (session()->has('data-signin')) {
                $user = \App\Entities\User::where('email', session('data-signin')['email'])->first();
            }
            $user_id = $user->id;
            $order_data = array();
            $order_data['customer_id'] = $user_id;
            $order_data['payment_type_id'] = $payment_id;
            $order_data['shipping_type_id'] = Session::get('shipping_id');

            //Nếu gỉỏ hàng rỗng
            if (Session::has('Cart') == null) {
                Session::put('message', 'Sorry, The cart is empty! Please order...');
                return view('web::checkout.payment');
            } //Giỏ hàng đã có sản phẩm được order
            else {
                foreach (Session::get('Cart')->products as $product) {
                    $order_data['total_prices'] = $product['productInfo']->price;
                }
                $order_data['order_status'] = 1;
                $order_id = DB::table('orders')->insertGetId($order_data);
                //insert order detail
                $order_detail_data = array();

                foreach (Session::get('Cart')->products as $product) {
                    $order_detail_data['order_id'] = $order_id;
                    $order_detail_data['product_id'] = $product['productInfo']->id;
                    $order_detail_data['quantity'] = $product['quanty'];
                    DB::table('order_details')->insert($order_detail_data);

                }
                if ($data['name'] == 'handcash') {
                    $brand_product = DB::table('brands')->orderby('id', 'desc')->get();
                    foreach (Session::get('Cart')->products as $product) {
                        $product_data = DB::table('products')->where('id', $order_detail_data['product_id'])->get();
                        foreach ($product_data as $item) {
                            $product_quantity = $item->quantity;
                        }
                        $quanti = $product_quantity - $order_detail_data['quantity'];
                        if ($quanti >= 0) {
                            DB::table('products')->where('id', $order_detail_data['product_id'])->update(['quantity' => $quanti]);

                            Session::put('message', 'Payment success!');
                            return view('web::checkout.handcash')->with('brand_product', $brand_product);
                        } else {
                            Session::put('message', 'Sorry, Quantity of products is not enough to order!');
                            return view('web::checkout.payment');
                        }
                    }
                } else {
                    return view('web::checkout.paypal');
                }
            }
        }
    }
    public function test(){
        $product_quantity = DB::table('products')->where('id', 4)->get();
        foreach ($product_quantity as $item) {
            echo $item->quantity;
        }    }
}
