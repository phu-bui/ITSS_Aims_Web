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
                        <a href="{{route('admin.add_user')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i>Add user</a>
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
                            <div class="info-box-content">
                                <span class="info-box-text">Total user</span>
                                <span class="info-box-number">{{count($user_total)}}</span>
                            </div>
                        </h5>
                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{($user->email)}}</td>
                                        <td>{{($user->phone)}}</td>
                                        <td>
                                            <?php
                                                if($user->role==1){
                                                    ?>
                                                <a href="{{route('admin.unblock_user', array('user_id'=>$user->userId))}}" class="btn btn-warning btn-icon-split">
                                                            <span class="icon text-white-50">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                    <span class="text">Unblock</span>
                                                </a>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                <a href="{{route('admin.block_user', array('user_id'=>$user->userId))}}" class="btn btn-warning btn-icon-split">
                                                            <span class="icon text-white-50">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                    <span class="text">Block</span>
                                                </a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.view_user', array('user_id'=>$user->userId))}}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                                <span class="text">View</span>
                                            </a>
                                            <a href="{{route('admin.delete_user', array('user_id'=>$user->userId))}}" onclick="return confirm('Are you sure you want to delete this user?')" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                                <span class="text">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{$users->links()}}
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
