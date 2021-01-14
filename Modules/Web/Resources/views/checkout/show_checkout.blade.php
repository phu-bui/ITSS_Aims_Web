@extends('web::layouts.master')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Checkout</li>
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
                        </div>
                        <div class="form-two">
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

                                <select name="country">
                                    <option>-- Country --</option>
                                    @foreach($countries as $country)
                                    <option>{{$country->country}}</option>
                                    @endforeach
                                </select>
                                <select name="city">
                                    <option>-- City --</option>
                                    @foreach($cities as $city)
                                    <option>{{$city->city}}</option>
                                    @endforeach
                                </select>
                                <select name="district">
                                    <option>-- District --</option>
                                    @foreach($districts as $district)
                                        <option>{{$district->district}}</option>
                                    @endforeach
                                </select>
                                <select name="wards">
                                    <option>-- Wards --</option>
                                    @foreach($wards as $ward)
                                    <option>{{$ward->wards}}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="description" id="description" placeholder="Description...">
                                <textarea name="shipping_notes" class="shipping_notes @error('shipNote') is-invalid @enderror" placeholder="Notes..." rows="5" required=""></textarea>
                                @error('shipNote')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                <input type="submit" value="Save" name="send_order_place" class="btn btn-primary br-sm">
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
