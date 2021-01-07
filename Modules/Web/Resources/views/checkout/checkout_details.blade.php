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
                                <form  action="{{route('web.show_update_checkout', array('ship_id'=>$ship->shipId))}}" method="GET">
                                    {{csrf_field()}}
                                    <div class="col-sm-4">
                                        <div class="contact-info">
                                            <h2 class="title text-center">Ship Info</h2>
                                            <address>
                                                <p>Name: {{$ship->shipName}}</p>
                                                <p>Address: {{$ship->shipAddress}}</p>
                                                <p>Mobile: {{$ship->shipPhone}}</p>
                                                <p>Email: {{$ship->shipEmail}}</p>
                                                <p>Note: {{$ship->shipNote}}</p>
                                            </address>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="submit" value="Update ship" name="send_order_place" class="btn btn-primary br-sm">
                                    <button type="button" value="Go to payment" name="send_order_place" class="btn btn-primary br-sm"><a href="{{route('web.payment', array('ship_id'=>$ship->shipId))}}">Go to payment</a></button>
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
