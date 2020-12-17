@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Order cart</li>
                </ol>
            </div>

            <div class="register-req">
                <!--<p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>--->
                <p>Customer information</p>
            </div><!--/register-req-->

            <div class="shopper-informations">
                <div class="row">

                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Fill in shipping information</p>
                            <div class="form-one">
                            @foreach($ship_by_order as $key => $ship)
                                <form  action="{{route('web.save-checkout-customer')}}" method="GET">
                                    {{csrf_field()}}
                                    <input type="text" name="shipping_name" class="shipping_name" value="{{$ship->shipName}}">
                                    <input type="text" name="shipping_phone" class="shipping_phone" value="{{$ship->shipPhone}}">
                                    <input type="text" name="shipping_email" class="shipping_email" value="{{$ship->shipEmail}}">
                                    <input type="text" name="shipping_address" class="shipping_address" value="{{$ship->shipAddress}}">
                                    <textarea name="shipping_notes" class="shipping_notes" placeholder="Shipping note..." rows="5"></textarea>
                                    <br>
                                    <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span class="text-alert">'.$message.'</span>';
                                        Session::put('message', null);
                                    }
                                    ?>
                                    <br>
                                    <input type="submit" value="Update ship" name="send_order_place" class="btn btn-primary br-sm">
                                    <button type="button" value="Go to payment" name="send_order_place" class="btn btn-primary br-sm"><a href="{{route('web.payment')}}">Go to payment</a></button>
                                </form>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 clearfix">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                    </div>

                </div>
            </div>




        </div>
    </section> <!--/#cart_items-->

@endsection
