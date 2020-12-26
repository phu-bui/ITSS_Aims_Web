@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Order history</li>
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
                            <p>Account information</p>

                                            <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">Order history</h6>
                                            <table class="table">
                                                <thead>
                                                <tr class="border">
                                                    <th scope="col" class="py-3 border-bottom-0 font-weight-medium pl-3 pl-lg-5">Order</th>
                                                    <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Date</th>
                                                    <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Staus</th>
                                                    <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Total</th>
                                                    <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders as $order)
                                                    <tr class="border">
                                                        <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">#{{$order->order_no}}</th>
                                                        <td class="align-middle py-5">{{$order->orderDate}}</td>
                                                        @if($order->orderStatus==1)
                                                            <td class="align-middle py-5"><span class="text-yellow-darker">Waitting...</span></td>
                                                            <td class="align-middle py-5">{{$order->totalPrices}} VND</td>
                                                            <td class="align-middle py-5">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="{{route('web.view_order_detail', array('ordered_id'=>$order->id))}}"> <button type="submit" class="btn btn-dark rounded-1 btn-wide font-weight-medium">View
                                                                        </button></a>
                                                                    <a href="{{route('web.order_remove', array('ordered_id'=>$order->id))}}"> <button type="submit" class="btn btn-dark rounded-1 btn-wide font-weight-medium">Remove
                                                                        </button></a>
                                                                </div>
                                                                <div class="d-flex justify-content-center">

                                                                </div>
                                                            </td>
                                                        @elseif($order->orderStatus==0)
                                                            <td class="align-middle py-5"><span class="text-primary">Canceled</span></td></td>
                                                            <td class="align-middle py-5">{{$order->totalPrices}} VND</td>
                                                            <td></td>
                                                        @else
                                                            <td class="align-middle py-5"><span class="text-bold">Delivered</span></td>
                                                            <td class="align-middle py-5">{{$order->totalPrices}} VND</td>
                                                            <td class="align-middle py-5">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="{{route('web.view_order_detail', array('ordered_id'=>$order->id))}}"> <button type="submit" class="btn btn-dark rounded-1 btn-wide font-weight-medium">View
                                                                        </button></a>
                                                                </div>
                                                                <div class="d-flex justify-content-center">

                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

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
