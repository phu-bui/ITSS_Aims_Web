@extends('admin::layouts.master')
@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box2 icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Product Management
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="list">
                <div class="main-card mb-3 card" >
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="info-box-content">
                                <span class="info-box-text">Total product</span>
                                <span class="info-box-number">{{count($products)}}</span>
                            </div>
                        </h5>
                        <div class="input-group mt-3 mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                    Category
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <a class="dropdown-item" href="{{route('admin.category_home', array('cate_name'=>$category->categoryName))}}">{{$category->categoryName}}</a>
   
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Value</th>
                                        <th>Quantity</th>
                                        <th>Update/Delete</th>
                                        <th>
                                            <div id="conditional_part">
                                                <button class="mb-2 btn btn-outline-success" id="delete-all" >Delete all</button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td><img width="60" class="" src="{{$product->image}}" alt=""></td>
                                        <td>{{$product->title}}</td>
                                        <td>{{($product->price)}}</td>
                                        <td>{{($product->value)}}</td>
                                        <td>
                                            @if($product->quantity > 0)
                                                <div class="mb-2 mr-2 badge badge-success">Stocking</div>
                                            @else
                                                <div class="mb-2 mr-2 badge badge-danger">Out of stock</div>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('admin.delete_product', array('product_id'=>$product->productId))}}">
                                                <button class="mb-2 mr-2 btn-transition btn btn-outline-success" onclick="return confirm('Are you sure you want to delete this product?')" >Delete</button>
                                            </form>
                                            <form action="{{route('admin.edit_product', array('product_id'=>$product->productId))}}"><button class="mb-2 mr-2 btn-transition btn btn-outline-primary">Detail</button></form>
                                        </td>
                                        <td><meta name="csrf-token" content="{{ csrf_token() }}">
                                            <input type="checkbox" name="product_name" value="{{$product->productId}}"  id="fluency"></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
   
    $(document).ready(function() {
        $("#delete-all").click(function(){
            var favorite = [];
            $.each($("input[name='product_name']:checked"), function(){            
                favorite.push($(this).val());
            });
            if(favorite.length > 0){
                $.ajax({
                    url: 'delete-list-product/',
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    type: 'POST',
                    data: {
                        favorite: favorite,
                         //services: services                     
                    },
                }).done(function(response){
                    window.location.href = "/admin/products";
                });    
            }            
        });
    });
</script>
@endsection
