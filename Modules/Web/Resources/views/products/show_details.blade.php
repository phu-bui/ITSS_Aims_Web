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
                @foreach($product as $key => $product)

                    <div class="col-sm-9 padding-right">
                        <div class="product-details"><!--products-details-->
                            <div class="col-sm-5">
                                <div class="view-product">
                                    <td><img width="60" class="" src="{{$product->image}}" alt=""></td>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="product-information"><!--/products-information-->
                                    <h2>{{$product->title}}</h2>
                                    <img src="{{asset('frontend/images/rating.png')}}" alt=""><br>
                                    <span>
									<span>{{$product->value}} VND</span>
                                        <p><del>{{number_format($product->value).' '.'VNĐ'}}</del></p>
									<label>Number of products:</label>
                                        <p>{{$product->quantity}}</p>
                                        <a onclick="AddCart({{$product->productId}})" href="javascript:" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        @endforeach
								</span>
                                    @foreach($product_details as $product_info)
                                    <p><b>{{$product_info->propertyName}}:</b> {{$product_info->value}}</p>
                                    @endforeach
                                </div><!--/products-information-->
                            </div>
                        </div><!--/products-details-->
                        <div class="recommended_items"><!--recommended_items-->
                            <h2 class="title text-center">recommended items</h2>

                            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        @foreach($product_same_category as $product)
                                        <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <a href="{{route('web.product_detail', array('product_id'=>$product->productId))}}"><td><img width="60" class="" src="{{$product->image}}" alt=""></td></a>
                                                        <h2>{{number_format($product->price).' '.'VND'}}</h2>
                                                        <p><del>{{number_format($product->value).' '.'VNĐ'}}</del></p>
                                                        <a href="{{route('web.product_detail', array('product_id'=>$product->productId))}}"><p>{{$product->title}}</p></a>
                                                        <p>Number of products: {{$product->quantity}}</p>
                                                        <a onclick="AddCart({{$product->productId}})" href="javascript:" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <!--features_items-->
                <!--/recommended_items-->
            </div>
        </div>
    </section>
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
