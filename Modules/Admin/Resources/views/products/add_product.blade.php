@extends('admin::layouts.master')

@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plus icon-gradient bg-happy-itmeo"></i>
                    </div>
                    <div>Add products
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
                <div class="page-title-actions">
                </div>    </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <form class="form-horizontal" action="{{route('admin.save_product')}}" method="post">
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
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title ..." required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Name input-->
                        <div class="col-md-4 mb-3">
                            <label for="name">Product Value</label>
                            <input type="text" class="form-control" id="value" name="value" placeholder="Value ..." required="">
                        </div>
                        <!-- Input image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="text" class="form-control" id="image" name="image" placeholder="Image ..." required="">
                        </div>


                    </div>
                    <div class="form-row">

                        <!-- Short description input-->
                        <div class="col-md-4 mb-3">
                            <label for="short_description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description..." required="">
                        </div>
                        <!-- Price input-->
                        <div class="col-md-4 mb-3">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price ..." required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Input vote -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity..." required="">
                        </div>

                        <!-- Status input-->
                        <div class="col-md-4 mb-3">
                            <label for="price">Language</label>
                            <input type="text" class="form-control" id="language" name="language" placeholder="Language..." required="">
                        </div>
                    </div>


                    <button class="btn btn-primary" type="submit">Save product</button>
                </form>

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
@endsection
