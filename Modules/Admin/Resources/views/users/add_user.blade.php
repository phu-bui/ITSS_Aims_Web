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
                        <h1 class="h3 mb-0 text-gray-800">User manager</h1>
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
                <h5 class="card-title">Users</h5>
                <form class="form-horizontal" action="{{route('admin.save_user')}}" method="get">
                    {{csrf_field()}}
                    <div class="form-row">

                        <!-- Slug input-->
                        <div class="col-md-4 mb-3">
                            <label for="slug">Name</label>
                            <input type="text" class="form-control" id="username" name="username"  required="">

                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Name input-->
                        <div class="col-md-4 mb-3">
                            <label for="name">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required="">
                            @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Input image -->
                        <div class="col-md-4 mb-3">
                            <label for="image">Phone number</label>
                            <input type="text" class="form-control " id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-row">

                        <!-- Short description input-->
                        <div class="col-md-4 mb-3">
                            <label for="short_description">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Price input-->

                    </div>

                    <div class="form-row">

                        <!-- Short description input-->
                        <div class="col-md-4 mb-3">
                            <label for="short_description">Role</label>
                            <input type="text" class="form-control" id="role" name="role">
                        </div>
                        <!-- Price input-->

                    </div>
                    <a href="{{route('admin.users.list')}}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                        <span class="text">Cancel</span>
                    </a>
                    <button class="btn btn-primary" type="submit">Save user</button>
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
    </div>
    </div>
@endsection
