@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">View profile</li>
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
                            <div class="form-one">
                                @foreach($user as $key => $user)
                                    <form  action="{{route('web.update_profile', array('user_id'=>$user->userId))}}" method="GET">
                                        {{csrf_field()}}
                                        <h3>User name</h3>
                                        <input type="text" name="user_name" class="shipping_name" value="{{$user->name}}">
                                        <h3>Email</h3>
                                        <input type="text" name="user_email" class="shipping_phone" value="{{$user->email}}">
                                        <h3>Phone number</h3>
                                        <input type="text" name="user_phone" class="shipping_email" value="{{$user->phone}}">
                                        <br>
                                        <?php
                                        $message = Session::get('message');
                                        if($message){
                                            echo '<span class="text-alert">'.$message.'</span>';
                                            Session::put('message', null);
                                        }
                                        ?>
                                        <br>
                                        <input type="submit" value="Update user" name="send_order_place" class="btn btn-primary br-sm">
                                        <button type="button" value="Cancel" name="send_order_place" class="btn btn-primary br-sm"><a href="{{route('web.home')}}">Cancel</a></button>
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
