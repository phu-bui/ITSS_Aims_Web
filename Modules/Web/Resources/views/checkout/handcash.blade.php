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

    <div class="empty-space col-xs-b35 col-md-b70"></div>
@endsection
