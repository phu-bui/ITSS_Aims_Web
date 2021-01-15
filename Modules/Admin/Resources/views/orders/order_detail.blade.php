@extends('admin::layouts.master')
@section('content')
    <div class="container-fluid">
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order detail</h1>
            <div>
                <div class="page-title-subheading">
                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message', null);
                    }
                    ?>
                </div>
            </div>
            <div></div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @foreach($ordered as $order)

                <table class="table table-borderless mb-0 ml-1">
                    <thead>
                    <tr>
                        <th scope="col" class="font-size-2 font-weight-normal py-0">Order no: </th>
                        <th scope="col" class="font-size-2 font-weight-normal py-0">Order date: </th>
                        <th scope="col" class="font-size-2 font-weight-normal py-0 text-md-center">Total: </th>
                        <th scope="col" class="font-size-2 font-weight-normal py-0 text-md-right pr-md-9">Payment method:</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td scope="row" class="pr-0 py-0 font-weight-medium">{{$order->order_no}}</td>
                        <td class="pr-0 py-0 font-weight-medium">{{$order->orderDate}}</td>
                        <td class="pr-0 py-0 font-weight-medium text-md-center">{{$order->totalPrices}}</td>
                        <td class="pr-md-4 py-0 font-weight-medium text-md-right">Thanh toán khi nhận </td>
                    </tr>
                    </tbody>
                </table>
                @if($order->orderStatus == 1)
                    <a href="{{route('admin.order_approval', array('order_id'=>$order->id))}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                        <span class="text">Delivered</span>
                    </a>
                @else()
                    <a href="{{route('admin.orders.list')}}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                        <span class="text">Cancel</span>
                    </a>
                @endif
            @endforeach

            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="dataTable_length">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="dataTable_filter" class="dataTables_filter">   </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">



                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 57px;">Title</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 62px;">Quantity</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 49px;">Total price</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($ordered_products as $product)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{$product->title}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->price*$product->quantity}}</td>
                            </tr>
                            @endforeach
                            @foreach($ordered as $order)

                            <tfoot>
                            <tr><th rowspan="1" colspan="1">Total</th>
                                <th rowspan="1" colspan="1"></th>
                                <th rowspan="1" colspan="1">{{$order->totalPrices}}</th>
                            </tr>

                            </tfoot>
                                @endforeach

                                </tbody>
                        </table>
                        @foreach($ship as $ship)

                            <table class="table table-borderless mb-0 ml-1">
                                <tr>
                                    <th>Name: </th>
                                    <td>{{$ship->shipName}}</td>
                                </tr>
                                <tr>
                                    <th>Phone: </th>
                                    <td>{{$ship->shipPhone}}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{$ship->shipEmail}} </td>
                                </tr>
                                <tr>
                                    <th>Note:</th>
                                    <td>{{$ship->shipNote}} </td>
                                </tr>
                                <thead>
                                <tr>
                                    <th>Address: </th>
                                    <td>{{$ship->shipAddress}}</td>
                                </tr>
                                </thead>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
@endsection
