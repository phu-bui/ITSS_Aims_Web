@extends('admin::layouts.master')
@section('content')
    <div class="container-fluid">
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
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="info-box-content">
                                <span class="info-box-text">Total product</span>
                                <span class="info-box-number">{{count($product_by_category)}}</span>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_by_category as $key => $product)
                                    <tr>

                                        <th scope="row">{{$key + 1}}</th>
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
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        {{$product_by_category->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
