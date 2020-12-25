@extends('web::layouts.master')
@section('content')
    <div class="container">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{route('web.home')}}">Home</a></li>
                <li class="active">Payment</li>
            </ol>
        </div>
        <div class="empty-space col-xs-b15 col-sm-b50 col-md-b100"></div>
        <div class="text-center">
            <div class="simple-article size-3 grey uppercase col-xs-b5">Hand cash</div>
            <div class="h2">Check your info</div>
            <div class="title-underline center"><span></span></div>
        </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message', null);
                }
                ?>
                <br>
                <h4 class="h4 col-xs-b25">Thank you!</h4>
            </div>
        </div>
    </div>
    <div class="bg-gray-200 space-bottom-3">
        <div class="container">
            <div class="py-5 py-lg-7">
                <h6 class="font-weight-medium font-size-7 text-center mt-lg-1">Đặt hàng thành công</h6>
            </div>
            <div class="max-width-890 mx-auto">
                <div class="bg-white pt-6 border">
                    <h6 class="font-size-3 font-weight-medium text-center mb-4 pb-xl-1">Cám ơn bạn đã đặt hàng trên hệ thống chúng tôi.</h6>
                    <div class="border-bottom mb-5 pb-5 overflow-auto overflow-md-visible">
                        <div class="pl-3">
                            @foreach($ordered_new as $order_new)
                                <table class="table table-borderless mb-0 ml-1">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="font-size-2 font-weight-normal py-0">Mã đơn hàng: </th>
                                        <th scope="col" class="font-size-2 font-weight-normal py-0">Ngày đặt: </th>
                                        <th scope="col" class="font-size-2 font-weight-normal py-0 text-md-center">Total: </th>
                                        <th scope="col" class="font-size-2 font-weight-normal py-0 text-md-right pr-md-9">Payment method: </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row" class="pr-0 py-0 font-weight-medium">{{$order_new->order_no}}</th>
                                        <td class="pr-0 py-0 font-weight-medium">{{$order_new->orderDate}}</td>
                                        <td class="pr-0 py-0 font-weight-medium text-md-center">{{$order_new->totalPrices}} VND</td>
                                        <td class="pr-md-4 py-0 font-weight-medium text-md-right">T{{$order_new->name}} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endforeach

                        </div>
                    </div>
                    <div class="border-bottom mb-5 pb-6">
                        <div class="px-3 px-md-4">
                            <div class="ml-md-2">
                                <h6 class="font-size-3 on-weight-medium mb-4 pb-1">Chi tiết đơn hàng</h6>

                            </div>
                        </div>
                    </div>
                    <div class="border-bottom mb-5 pb-4">
                        <div class="px-3 pl-md-5 pr-md-4">
                            <div class="d-flex justify-content-between">
                                <span class="font-size-2 font-weight-medium">Total</span>
                                <span class="font-weight-medium fon-size-2">{{$subtotal}} VND</span>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="px-3 pl-md-5 pr-md-4 mb-6 pb-xl-1">
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <div class="mb-6 mb-md-0">
                                    <h6 class="font-weight-medium font-size-22 mb-3">Billing Address
                                    </h6>
                                    <address class="d-flex flex-column mb-0">
                                        <span class="text-gray-600 font-size-2">Hà Nội</span>
                                        <span class="text-gray-600 font-size-2">Số 1 Đại Cồ Việt, Hai Bà Tr</span>
                                        <span class="text-gray-600 font-size-2">0986868686</span>
                                        <span class="text-gray-600 font-size-2">hust@hust.edu.vn</span>
                                        <span class="text-gray-600 font-size-2">Đại học Bách Khoa Hà Nội</span>
                                    </address>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-medium font-size-22 mb-3">Shipping Address
                                </h6>
                                @foreach($shipping as $ship)
                                    <address class="d-flex flex-column mb-0">
                                        <span class="text-gray-600 font-size-2">{{$ship->province}}</span>
                                        <span class="text-gray-600 font-size-2">{{$ship->address}}</span>
                                        <span class="text-gray-600 font-size-2">{{$ship->receiver_phone_number}} </span>
                                        <span class="text-gray-600 font-size-2">{{$ship->receiver_email}}</span>
                                        <span class="text-gray-600 font-size-2">{{$ship->receiver_name}}</span>
                                    </address>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>
@endsection
