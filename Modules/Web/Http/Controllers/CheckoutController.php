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
use Modules\Web\Http\Requests\ShippingRequest;
use Session;
use App\Http\Requests;
session_start();

class CheckoutController extends Controller
{

    public function checkout(Request $request){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();

        return view('web::checkout.show_checkout')
            ->with('category_product', $category_product);
    }

    public function show_checkout($user_id){
        $ship_by_order = DB::table('ships')->join('orders', 'ships.id', '=','orders.shipId')->where('orders.userId', $user_id)->orderby('ships.id','desc')->limit(1)->get();
        $countries = DB::table('address')->orderby('id', 'desc')->get();
        foreach ($countries as $country) {
            $country_id = $country->id;
        }
        $cities = DB::table('address')->where('id', $country_id)->get();
        foreach ($cities as $city){
            $city_id = $city->id;
        }
        $districts = DB::table('address')->where('id', $city_id)->get();
        foreach ($districts as $district) {
            $district_id = $district->id;
        }
        $wards = DB::table('address')->where('id', $district_id)->get();
        if(sizeof($ship_by_order) == 0){
            return view('web::checkout.show_checkout')
                ->with('countries', $countries)
                ->with('cities', $cities)
                ->with('districts', $districts)
                ->with('wards', $wards);
        }
        else {
            return view('web::checkout.checkout_details')->with('ship_by_order', $ship_by_order);
        }
    }

    public function save_checkout_customer(ShippingRequest  $requests){
        $ship_address = $requests->country.', '.$requests->city.', '.$requests->district.', '.$requests->wards.', '.$requests->description;
        $address_info = DB::table('address')->where('wards', $requests->wards)->get();
        foreach ($address_info as $add_info) {
            $ship_cost = $add_info->shipCost;
        }
        $data_ship = array();
        $data_ship['shipName'] = $requests->shipping_name;
        $data_ship['shipAddress'] = $ship_address;
        $data_ship['shipPhone'] = $requests->shipping_phone;
        $data_ship['shipEmail'] = $requests->shipping_email;
        $data_ship['cost'] = $ship_cost;
        if($requests->shipping_notes == NULL){
            $shipping_id = Session::get('shipping_id');
            Session::put('message', 'Please update shipping note!');
            return redirect()->route('web.show_checkout', array('shipping_id'=>$shipping_id));
        }
        else {
            $data_ship['shipNote'] = $requests->shipping_notes;
        }

        $shipping_id = DB::table('ships')->insertGetId($data_ship);
        Session::put('shipping_id', $shipping_id);
        return redirect()->route('web.payment', array('ship_id'=>$shipping_id));

    }

    public function show_update_checkout($ship_id){
        $countries = DB::table('address')->orderby('id', 'desc')->get();
        foreach ($countries as $country) {
            $country_id = $country->id;
        }
        $cities = DB::table('address')->where('id', $country_id)->get();
        foreach ($cities as $city){
            $city_id = $city->id;
        }
        $districts = DB::table('address')->where('id', $city_id)->get();
        foreach ($districts as $district) {
            $district_id = $district->id;
        }
        $wards = DB::table('address')->where('id', $district_id)->get();

        return view('web::checkout.show_update_checkout')
            ->with('countries', $countries)
            ->with('cities', $cities)
            ->with('districts', $districts)
            ->with('wards', $wards)
            ->with('ship_id', $ship_id);
    }

    public function save_update_checkout_customer(ShippingRequest  $requests, $ship_id){
        $ship_address = $requests->country.', '.$requests->city.', '.$requests->district.', '.$requests->wards.', '.$requests->description;
        $address_info = DB::table('address')->where('wards', $requests->wards)->get();
        foreach ($address_info as $add_info) {
            $ship_cost = $add_info->shipCost;
        }
        $data_ship = array();
        $data_ship['shipName'] = $requests->shipping_name;
        $data_ship['shipAddress'] = $ship_address;
        $data_ship['shipPhone'] = $requests->shipping_phone;
        $data_ship['shipEmail'] = $requests->shipping_email;
        $data_ship['cost'] = $ship_cost;
        $data_ship['shipNote'] = $requests->shipping_notes;

        DB::table('ships')->where('shipId', $ship_id)->update($data_ship);
        return redirect()->route('web.payment', array('ship_id'=>$ship_id));

    }

    public function payment($ship_id){
        $category_product = DB::table('categories')->orderby('categoryId', 'desc')->get();
        $ship_info = DB::table('ships')->where('shipId', $ship_id)->get();
        foreach ($ship_info as $info) {
            $ship_cost = $info->cost;
        }
        return view('web::checkout.payment')->with('category_product', $category_product)
            ->with('ship_cost', $ship_cost);
    }

    public function order_place(Request $request)
    {
        if (session()->has('data-signin')) {
            $user = \App\Entities\User::where('email', session('data-signin')['email'])->first();
        }
        $user_id = $user->userId;
        $ship_by_order = DB::table('ships')->join('orders', 'ships.shipId', '=', 'orders.shipId')->where('orders.userId', $user_id)->orderby('ships.shipId', 'desc')->limit(1)->get();
        if(sizeof($ship_by_order) == 0){
            $ship_new = DB::table('ships')->orderby('shipId', 'desc')->limit(1)->get();
            foreach ($ship_new as $ship){
                $ship_id = $ship->shipId;
            }
        }else {
            foreach ($ship_by_order as $ship) {
                $ship_id = $ship->shipId;
            }
        }
        //insert payment
        $data = array();
        $data['name'] = $request->payment_option;
        if ($data['name'] == null) {
            Session::put('message', 'Sorry, Please choose your form of payment!');
            return view('web::checkout.payment');
        } else {
            $payment_info = DB::table('payment_methods')->join('payments', 'payment_methods.paymentMethodId', '=', 'payments.paymentMethodId')->where('payment_methods.paymentName', $data['name'])->get();
            foreach ($payment_info as $pay_info){
                $payment_id = $pay_info->paymentId;
            }
            //insert order

            if ($data['name'] == 'handcash') {
                $ship_info = DB::table('ships')->where('shipId', $ship_id)->get();
                foreach ($ship_info as $info) {
                    $ship_cost = $info->cost;
                }
                if (session()->has('data-signin')) {
                    $user = \App\Entities\User::where('email', session('data-signin')['email'])->first();
                }
                $user_id = $user->userId;
                $order_data = array();
                $order_data['userId'] = $user_id;
                $order_data['paymentId'] = $payment_id;
                $order_data['order_no'] = rand(1, 10000);
                $order_data['shipId'] = $ship_id;
                $order_data['totalPrices'] = $ship_cost;

                $total_price = 0;
                //Nếu gỉỏ hàng rỗng
                if (Session::has('Cart') == null) {
                    Session::put('message', 'Sorry, The cart is empty! Please order...');
                    return view('web::checkout.payment');
                } //Giỏ hàng đã có sản phẩm được order
                else {
                    foreach (Session::get('Cart')->products as $product) {
                         $total_price += $product['productInfo']->price*$product['quanty'];
                    }
                    $vat = $total_price*0.1;
                    $total_price+=$vat;
                    $order_data['totalPrices'] += $total_price;
                    $order_data['orderStatus'] = 1;
                    $order_id = DB::table('orders')->insertGetId($order_data);
                    //insert order detail
                    $order_detail_data = array();

                    foreach (Session::get('Cart')->products as $product) {
                        $order_detail_data['orderId'] = $order_id;
                        $order_detail_data['productId'] = $product['productInfo']->productId;
                        $order_detail_data['quantity'] = $product['quanty'];
                        DB::table('orderDetails')->insert($order_detail_data);

                    }
                    foreach (Session::get('Cart')->products as $product) {
                        $product_data = DB::table('products')->where('productId', $product['productInfo']->productId)->get();
                    }
                    foreach ($product_data as $item) {
                        $product_quantity = $item->quantity;
                    }
                    $quanti = $product_quantity - $order_detail_data['quantity'];
                    if ($quanti >= 0) {
                        DB::table('products')->where('productId', $order_detail_data['productId'])->update(['quantity' => $quanti]);
                        $request->Session()->forget('Cart');
                        $ordered_new = DB::table('orders')->join('payments', 'orders.paymentId', '=', 'payments.paymentId')->where('orders.id', $order_id)->get();
                        $product_ordered = DB::table('products')->join('orderDetails', 'products.productId', '=', 'orderDetails.productId')->where('orderDetails.orderId', $order_id)->get();
                        $shipping = DB::table('ships')->join('orders', 'ships.shipId', '=', 'orders.shipId')->where('orders.id', $order_id)->get();
                        Session::put('message', 'Payment success!');
                        return view('web::checkout.success')
                            ->with('ordered_new', $ordered_new)
                            ->with('product_ordered', $product_ordered)
                            ->with('shipping', $shipping)
                            ->with('payment_info', $payment_info)->with('vat', $vat);
                    } else {
                        Session::put('message', 'Sorry, Quantity of products is not enough to order!');
                        return view('web::checkout.payment')->with('ship_cost', $ship_cost);
                    }
                }
            } else {
                if (Session::has('Cart') == null) {
                    Session::put('message', 'Sorry, The cart is empty! Please order...');
                    return view('web::checkout.payment');
                }
                else {
                    return view('web::checkout.paypal');
                }
            }
        }
    }

    public function paypal(Request $request){
        $payment_method_info = DB::table('payment_methods')->where('paymentName', 'paypal')->get();
        foreach ($payment_method_info as $pay_info){
            $payment_method_id = $pay_info->paymentMethodId;
        }

        $payment_code = $request->paypal_code;
        $payment_data = DB::table('payments')->where('paymentCode', $payment_code)->get();
        foreach ($payment_data as $paypal) {
            $paypal_money = $paypal->paymentMoney;
            $payment_id = $paypal->paymentId;
        }
        if (sizeof($payment_data) == 0){
            Session::put('message', 'Sorry, Paypal code is not ready to accept payment! Please enter another paypal code...');
            return view('web::checkout.paypal');
        }
        else {
            if (session()->has('data-signin')) {
                $user = \App\Entities\User::where('email', session('data-signin')['email'])->first();
            }
            $user_id = $user->userId;
            $ship_by_order = DB::table('ships')->join('orders', 'ships.shipId', '=', 'orders.shipId')->where('orders.userId', $user_id)->orderby('ships.shipId', 'desc')->limit(1)->get();
            foreach ($ship_by_order as $ship) {
                $ship_id = $ship->shipId;
            }
            $ship_info = DB::table('ships')->where('shipId', $ship_id)->get();
            foreach ($ship_info as $info) {
                $ship_cost = $info->cost;
            }

            $order_data = array();
            $order_data['userId'] = $user_id;
            $order_data['paymentId'] = $payment_id;
            $order_data['order_no'] = rand(1, 10000);
            $order_data['shipId'] = $ship_id;
            $order_data['totalPrices'] = $ship_cost;

            $total_price = 0;
            //Nếu gỉỏ hàng rỗng
            if (Session::has('Cart') == null) {
                Session::put('message', 'Sorry, The cart is empty! Please order...');
                return view('web::checkout.payment');
            } //Giỏ hàng đã có sản phẩm được order
            else {
                foreach (Session::get('Cart')->products as $product) {
                     $total_price += $product['productInfo']->price * $product['quanty'];
                }
                $vat = $total_price*0.1;
                $total_price += $vat;
                $order_data['totalPrices'] += $total_price;
                $order_data['orderStatus'] = 1;
                $order_id = DB::table('orders')->insertGetId($order_data);

                //insert order detail
                $order_detail_data = array();

                foreach (Session::get('Cart')->products as $product) {
                    $order_detail_data['orderId'] = $order_id;
                    $order_detail_data['productId'] = $product['productInfo']->productId;
                    $order_detail_data['quantity'] = $product['quanty'];
                    DB::table('orderDetails')->insert($order_detail_data);

                }
                foreach (Session::get('Cart')->products as $product) {
                    $product_data = DB::table('products')->where('productId', $product['productInfo']->productId)->get();
                }
                foreach ($product_data as $item) {
                    $product_quantity = $item->quantity;
                }
                $quanti = $product_quantity - $order_detail_data['quantity'];
                if ($quanti >= 0) {
                    DB::table('products')->where('productId', $order_detail_data['productId'])->update(['quantity' => $quanti]);
                    $request->Session()->forget('Cart');
                    $paypal_money  -= $order_data['totalPrices'];
                    DB::table('payments')->where('paymentCode', $payment_code)->update(['paymentMoney'=>$paypal_money]);
                    $ordered_new = DB::table('orders')->join('payments', 'orders.paymentId', '=', 'payments.paymentId')->where('orders.id', $order_id)->get();
                    $product_ordered = DB::table('products')->join('orderDetails', 'products.productId', '=', 'orderDetails.productId')->where('orderDetails.orderId', $order_id)->get();
                    $shipping = DB::table('ships')->join('orders', 'ships.shipId', '=', 'orders.shipId')->where('orders.id', $order_id)->get();
                    Session::put('message', 'Payment success!');
                    return view('web::checkout.success')
                        ->with('ordered_new', $ordered_new)
                        ->with('product_ordered', $product_ordered)
                        ->with('shipping', $shipping)
                        ->with('payment_info', $payment_method_info)
                        ->with('vat', $vat);
                } else {
                    Session::put('message', 'Sorry, Quantity of products is not enough to order!');
                    return view('web::checkout.payment');
                }
            }
        }
    }
}
