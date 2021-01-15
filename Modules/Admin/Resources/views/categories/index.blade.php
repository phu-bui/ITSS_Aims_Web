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
                        <h1 class="h3 mb-0 text-gray-800">Category manager</h1>
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
                        <a href="{{route('admin.add_category')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-flag fa-sm text-white-50"></i>Add category</a>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">

                        </h5>
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Update/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $category)
                                    <tr>
                                        <td>{{$category->categoryId}}</td>
                                        <td>{{($category->categoryName)}}</td>
                                        @if($category->type == 1)
                                            <td>PhysicGood</td>
                                        @else
                                            <td>EGood</td>
                                        @endif
                                        <td>
                                            <a href="{{route('admin.edit_category', array('category_id'=>$category->categoryId))}}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                                <span class="text">View</span>
                                            </a>
                                            <a href="{{route('admin.delete_category', array('category_id'=>$category->categoryId))}}" onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-danger btn-icon-split">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
