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
                        <a href="{{route('admin.add_promotion')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-flag fa-sm text-white-50"></i>Add promotion</a>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card" id="category">
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="info-box-content">
                                <span class="info-box-text">Total promotion</span>
                                <span class="info-box-number">{{count($promotions_total)}}</span>
                            </div>
                        </h5>


                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Discount</th>
                                        <th>Number product discount</th>
                                        <th>Start at</th>
                                        <th>End at</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($promotions as $index => $promotion)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td>{{$promotion->name}}</td>
                                        <td>{{$promotion->type}}</td>
                                        <td>{{$promotion->description}}</td>
                                        <td>{{($promotion->discount)}}</td>
                                        <td>{{($promotion->num_product_discount)}}</td>
                                        <td>{{$promotion->start_at}}</td>
                                        <td>{{$promotion->end_at}}</td>
                                        <td>
                                            @if(!($promotion->category_id))
                                                <div class="mb-2 mr-2 badge badge-danger">Not applicable yet</div>
                                            @else
                                                <div class="mb-2 mr-2 badge badge-success">Applied</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.add_product_to_promotion', array('promotion_id'=>$promotion->promotionId))}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                                <span class="text">Start</span>
                                            </a>
                                            <a href="{{route('admin.edit_promotion', array('promotion_id'=>$promotion->promotionId))}}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                                <span class="text">View</span>
                                            </a>
                                            <a href="{{route('admin.delete_promotion', array('promotion_id'=>$promotion->promotionId))}}" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                                <span class="text">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        {{$promotions->links()}}
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
            $("#delete-all").click(function(){
                if (confirm('Are you sure you want to delete this products?')) {
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
                }
            });
        });
    </script>
@endsection
