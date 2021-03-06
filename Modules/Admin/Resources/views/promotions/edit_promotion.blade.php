@extends('admin::layouts.master')

@section('content')
    <div class="container-fluid">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-eyedropper icon-gradient bg-happy-itmeo"></i>
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
                <div class="page-title-actions">
                </div>    </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Promotion</h5>
                @foreach($promotions as $key => $promotion)
                <form class="form-horizontal" action="{{route('admin.update_promotion', array('promotion_id'=>$promotion->promotionId))}}" method="get">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="">Promotion Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="" selected>---</option>
                                @foreach(\App\Entities\Promotion::$typePromotions as $key => $typePromotion)
                                    <option value="{{$key}}" @if($key == old('type')) selected @endif>{{$typePromotion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Slug input-->
                        <div class="col-md-4 mb-3">
                            <label for="slug">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$promotion->name}}" placeholder="Name ..." required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Name input-->
                        <div class="col-md-4 mb-3">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{$promotion->description}}" placeholder="Description ..." required="">
                        </div>
                        <!-- Input image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Discount(%)</label>
                            <input type="number" class="form-control" id="discount" name="discount" value="{{$promotion->discount}}" placeholder="Discount ..." required="">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="image">Number product discount</label>
                            <input type="number" class="form-control" id="number" name="number" value="{{$promotion->num_product_discount}}" placeholder="Number ..." required="">
                        </div>

                    </div>
                    <div class="form-row">

                        <!-- Short description input-->
                        <div class="col-md-4 mb-3">
                            <label for="short_description">Start at</label>
                            <input type="datetime-local" class="form-control" id="start_at" name="start_at" value="{{$promotion->start_at}}" placeholder="Start..." required="">
                        </div>
                        <!-- Price input-->
                        <div class="col-md-4 mb-3">
                            <label for="price">End at</label>
                            <input type="datetime-local" class="form-control" id="end_at" name="end_at" value="{{$promotion->end_at}}" placeholder="End ..." required="">
                        </div>
                    </div>
                    <a href="{{route('admin.promotions.list')}}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                        <span class="text">Cancel</span>
                    </a>
                    <button class="btn btn-primary" type="submit">Update promotion</button>
                </form>
                @endforeach
                <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
            </div>
        </div>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </div>
    </div>
@endsection
