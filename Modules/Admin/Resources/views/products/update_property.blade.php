@extends('admin::layouts.master')

@section('content')
    <div class="container-fluid">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-plus icon-gradient bg-happy-itmeo"></i>
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
                <form class="form-horizontal" action="{{route('admin.update_property', array('product_id'=>$product_id))}}" method="post">
                    @csrf

                    @foreach($properties as $property)
                        <div class="form-group">
                            <label for="">{{$property->propertyName}}</label>
                            <input type="text" class="form-control" name="{{$property->propertyTypeId}}" value="{{$property->value}}" placeholder="">
                        </div>
                    @endforeach
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection


