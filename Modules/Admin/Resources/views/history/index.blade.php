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
                    <div>History Management
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

                        </h5>
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>AdminName</th>
                                        <th>Act</th>
                                        <th>Date</th>
                                        <th>Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($adminHistory as $index => $history)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td>{{$history->name}}</td>
                                        <td>{{$history->act}}</td>
                                        <td>{{$history->createDate}}</td>
                                        <td>{{$history->productId}}</td>
                                    </tr>
                                    @endforeach
                                    {{$adminHistory->links()}}
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
@endsection
