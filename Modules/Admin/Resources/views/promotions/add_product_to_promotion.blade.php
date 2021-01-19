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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Promotion manager</h1>
                        <div>
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
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card" id="category">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Promotion Name</th>
                                        <th>Number of product</th>
                                        <th>Discount</th>
                                        <th>Category of product</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($promotions as $index => $promotion)
                                    <tr>
                                        <td>{{$promotion->name}}</td>
                                        <td>{{($promotion->num_product_discount)}}</td>
                                        <td>{{($promotion->discount)}}</td>
                                        <form class="form-horizontal" action="{{route('admin.save_add', array('promotion_id'=>$promotion->promotionId))}}" method="get">
                                            @csrf
                                        <td>
                                        <select class="form-control" id="category" name="categoryId" required>
                                            <option value="" selected>---</option>
                                            @foreach($category_product as $category)
                                                <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                            @endforeach
                                        </select>
                                        </td>
                                        <td>

                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </td>
                                        </form>
                                    </tr>

                                    @endforeach


                                </tbody>
                            </table>
                            <tr>
                                <a href="{{route('admin.promotions.list')}}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                    <span class="text">Cancel</span>
                                </a></tr>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{asset('frontend/js/jquery-3.2.1.min.js')}}"></script>

    <script>

        $(document).ready(function() {
            $("#add-all").click(function(){
                if (confirm('Are you sure you want to delete this products?')) {
                    var favorite = [];
                    $.each($("input[name='product_name']:checked"), function(){
                        favorite.push($(this).val());
                    });
                    if(favorite.length > 0){
                        $.ajax({
                            url: 'save-add-product-to-promotion/',
                            headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            type: 'POST',
                            data: {
                                favorite: favorite,
                                 //services: services
                            },
                        }).done(function(response){
                            window.location.href = "/admin/promotions";
                        });
                    }
                }
            });
        });
    </script>
@endsection
