@extends('admin::layouts.master')
@section('content')
    <div class="container-fluid">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box2 icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Order manager</h1>
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
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="info-box-content">
                                <span class="info-box-text">Total order</span>
                                <span class="info-box-number">{{count($orders)}}</span>
                            </div>
                        </h5>
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order no</th>
                                    <th>User</th>
                                    <th>Total prices</th>
                                    <th>Order date</th>
                                    <th>Order status</th>
                                    <th>View/Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $index => $order)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td>{{$order->order_no}}</td>
                                        <td>{{$order->userId}}</td>
                                        <td>{{($order->totalPrices)}}</td>
                                        <td>{{($order->orderDate)}}</td>
                                        <td>
                                            @if($order->orderStatus == 0)
                                                <div class="mb-2 mr-2 badge badge-danger">Canceled</div>
                                            @elseif($order->orderStatus ==1)
                                                <div class="mb-2 mr-2 badge badge-success">Waiting</div>
                                            @else
                                                <div class="mb-2 mr-2 badge badge-carolina">Delivered</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.view_order', array('order_id'=>$order->id))}}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                                <span class="text">View</span>
                                            </a>
                                            <a href="{{route('admin.delete_order', array('order_id'=>$order->id))}}" onclick="return confirm('Are you sure you want to delete this order?')" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                                <span class="text">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                {{$orders->links()}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
