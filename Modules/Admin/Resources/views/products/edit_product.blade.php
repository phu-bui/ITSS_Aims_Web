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
                        <h1 class="h3 mb-0 text-gray-800">Product manager</h1>
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
                <h5 class="card-title">Products</h5>
                @foreach($products as $key => $pro)
                <form class="form-horizontal" action="{{route('admin.update_product', array('product_id'=>$pro->productId))}}" method="post">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control">
                                @foreach($category_product as $key => $category)
                                    <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Slug input-->
                        <div class="col-md-4 mb-3">
                            <label for="slug">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{$pro->title}}"  required="">
                            @error('title')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Name input-->
                        <div class="col-md-4 mb-3">
                            <label for="name">Product Value</label>
                            <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{$pro->value}}" required="">
                            @error('value')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Input image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{$pro->image}}" required="">
                            @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                    <div class="form-row">

                        <!-- Short description input-->
                        <div class="col-md-4 mb-3">
                            <label for="short_description">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{$pro->description}}" required="">
                            @error('description')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Price input-->
                        <div class="col-md-4 mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{$pro->price}}" required="">
                            @error('price')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Input vote -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{$pro->quantity}}" required="">
                            @error('quantity')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status input-->
                        <div class="col-md-4 mb-3">
                            <label for="price">Language</label>
                            <input type="text" class="form-control @error('language') is-invalid @enderror" id="language" name="language" value="{{$pro->language}}" required="">
                            @error('language')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <a href="{{route('admin.products.list')}}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                        <span class="text">Cancel</span>
                    </a>
                    <button class="btn btn-primary" type="submit">Continue</button>
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
