@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Change user password</li>
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
                            <p>Change password</p>
                            <div class="form-one">
                                @foreach($user as $key => $user)
                                    <form  action="{{route('web.save_update_password', array('user_id'=>$user->userId))}}" method="GET">
                                        {{csrf_field()}}
                                        <h3>Current password</h3>
                                        <input type="password" id="user-password" name="user_password" class="shipping_name" placeholder="Input current password...">
                                        <h3>New password</h3>
                                        <input type="password" name="user_new_password" class="shipping_phone" placeholder="Input new password...">
                                        <br>
                                        <?php
                                        $message = Session::get('message');
                                        if($message){
                                            echo '<span class="text-alert">'.$message.'</span>';
                                            Session::put('message', null);
                                        }
                                        ?>
                                        <br>
                                        <input type="submit" value="Change password" name="send_order_place" class="btn btn-primary br-sm">
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
