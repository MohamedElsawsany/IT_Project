@extends('layouts.it_nassargroup_layout')
@section('usersLinkActive','active')
@section('page_title','Users')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Users\Deleted</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item active">Deleted</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="deletedUsersTable" class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th>Deleted By</th>
                                    <th>Deleted Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Branch</th>
                                    <th>Deleted By</th>
                                    <th>Deleted Date</th>
                                    <th>Actions</th>
                                </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('users.force_delete_modal')
@endsection

@section("Js_Page")
    @include('users.deletedUsersJS')
@endsection


