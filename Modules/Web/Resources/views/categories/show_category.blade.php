@extends('web::layouts.master')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <div class="brands_products"><!--brands_products-->
                            <h2>Brands</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($categories as $key => $category)
                                        <li><a href="{{route('web.category_home', array('cate_name'=>$category->categoryName))}}"> <span class="pull-right"></span>{{$category->categoryName}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div><!--/brands_products-->

                        <div class="price-range"><!--price-range-->
                            <h2>Price Range</h2>
                            <div class="well text-center">
                                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div><!--/price-range-->

                        <div class="shipping text-center"><!--shipping-->
                            <img src="{{asset('frontend/images/shipping.jpg')}}" alt="" />
                        </div><!--/shipping-->

                    </div>
                </div>
                <div class="features_items"><!--features_items-->

                        @foreach($category_name as $key => $name)

                        <h2 class="title text-center">{{$name->categoryName}}</h2>

                        @endforeach
                        @foreach($product_by_category as $key => $product)

                        <div class="col-sm-4">
                            <div class="product-image-wrapper">

                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <a href="{{route('web.product_detail', array('product_id'=>$product->productId))}}"><td><img width="60" class="" src="{{$product->image}}" alt=""></td></a>
                                            <h2>{{number_format($product->price).' '.'VNĐ'}}</h2>
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
                        </a>
                        @endforeach

                        {{$product_by_category->links()}}
                    </div><!--features_items-->
        <!--/recommended_items-->
            </div>
        </div>
    </section>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        function AddCart(id){
            let link = '{{route('web.add_cart', ':id')}}'
            link = link.replace(':id', id)
            $.ajax({
                url: link,
                type: 'GET',
            }).done(function(response){
                alertify.success('Add to cart successful!');
            });
        }
    </script>
@endsection
