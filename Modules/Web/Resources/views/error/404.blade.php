@extends('web::layouts.master')
@section('content')
<div class="container text-center">

		<div class="content-404">
			<img src="{{asset('frontend/images/404.png')}}" class="img-responsive" alt="" />
			<h1><b>OPPS!</b> We Couldn’t Find this Page</h1>
			<p>Uh... So it looks like you brock something. You need to login to view related information.</p>
		</div>
	</div>
@endsection
