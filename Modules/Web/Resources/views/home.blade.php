@extends('web::layouts.master')
@section('content')
    <section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">

                    <div class="brands_products"><!--brands_products-->
                        <h2>Category</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($category_product as $key => $category)
                                    <li><a href="{{route('web.category_home', array('cate_name'=>$category->categoryName))}}"> <span class="pull-right"></span>{{$category->categoryName}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div><!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Price Range</h2>
                        <div class="well text-center">
                            <form method="get" id="form_order">
                            <select name="orderby" class="orderby" >
                                <option {{Request::get('orderby') == "desc" ? "selected='selected'" : ""}} value="{{Request::url()}}?orderby=sdesc">Sản phẩm mới</option>
                                <option {{Request::get('orderby') == "asc" ? "selected='selected'" : ""}} value="asc">Sản phẩm cũ</option>
                                <option {{Request::get('orderby') == "price_max" ? "selected='selected'" : ""}} value="price_max">Giá giảm dần</option>
                                <option {{Request::get('orderby') == "price_min" ? "selected='selected'" : ""}} value="price_min">Giá tăng dần</option>
                            </select>                       
                            </form>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="{{asset('frontend/images/shipping.jpg')}}" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Features Items</h2>
                    @foreach($products as $key => $product)
                        @foreach($category_product as $key => $category)
                        @endforeach
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">

                                    <div class="single-products" ">
                                        <div class="productinfo text-center" >
                                            <a href="{{route('web.product_detail', array('product_id'=>$product->productId))}}"><td><img width="60" class="" src="{{$product->image}}" alt=""></td></a>
                                            <h2>{{number_format($product->price).' '.'VND'}}</h2>
                                            <p><del>{{number_format($product->value).' '.'VNĐ'}}</del></p>
                                            <a href="{{route('web.product_detail', array('product_id'=>$product->productId))}}"><p>{{$product->title}}</p></a>
                                            <p>Number of products: {{$product->quantity}}</p>
                                            <a onclick="AddCart({{$product->productId}})" href="javascript:" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>

                                    </div>

                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href=""><i class="fa fa-plus-square"></i>Favourite</a></li>
                                            <li><a href=""><i class="fa fa-plus-square"></i>Compare</a></li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                @endforeach             


                </div>
                {{ $products->appends(request()->query())->links() }}

            </div>
        </div>
    </div>
</section>


<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script src="{{asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
<script>
    function AddCart(id){
        console.log(id)
        $.ajax({
            url: 'addcart/'+id,
            type: 'GET',
        }).done(function(response){
           alertify.success('Add to cart successful!');
        });
    }
</script>

<script>
    $(function(){
        $('.orderby').change(function () {
            $("#form_order").submit();
        })
    }) 
</script>

@endsection
