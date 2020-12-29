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
                                <form  action="{{route('web.save-checkout-customer')}}" method="GET">
                                    {{csrf_field()}}
                                    <input type="text" name="shipping_name"  class="shipping_name @error('shipName') is-invalid @enderror" placeholder="Your name..."  required="">
                                    @error('shipName')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input type="text" name="shipping_phone" class="shipping_phone @error('shipPhone') is-invalid @enderror" placeholder="Your phone..." required="">
                                    @error('shipPhone')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input type="text" name="shipping_email" class="shipping_email @error('shipEmail') is-invalid @enderror" placeholder="Your email..." required="">
                                    @error('shipEmail')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input type="text" name="shipping_address" class="shipping_address  @error('shipAddress') is-invalid @enderror" placeholder="Your address..." required="">
                                    @error('shipAddress')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <textarea name="shipping_notes" class="shipping_notes @error('shipNote') is-invalid @enderror" placeholder="Notes..." rows="5" required=""></textarea>
                                    @error('shipNote')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <input type="submit" value="Save" name="send_order_place" class="btn btn-primary br-sm">

                                </form>
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
