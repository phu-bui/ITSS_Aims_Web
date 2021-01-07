@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Payment</li>
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
                            <p>Paypal information</p>
                        </div>
                        <div class="form-two">
                            <form  action="{{route('web.paypal')}}" method="GET">
                                {{csrf_field()}}
                                <input type="text" name="paypal_code"  class="paypal_code" placeholder="Paypal code consists of 10 numeric characters..."  required="">
                                <input type="submit" value="Payment" name="send_order_place" class="btn btn-primary br-sm">
                            </form>
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
