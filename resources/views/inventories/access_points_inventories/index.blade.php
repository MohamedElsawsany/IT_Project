@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('accessPointLinkActive','active')
@section('page_title','Inventories - Access Points')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Access Points</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Access Points</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    {{--        Access Points CRUD                  --}}

                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#addAccessPointModal">
                                Add New Access Point
                            </button>
                            <a href="{{route('access_points.delivered_access_points_index')}}" class="btn btn-outline-info">
                                Delivered Access Points
                            </a>
                            <button type="button" class="btn btn-outline-secondary" id="refreshAccessPointsTable"><i
                                    class="fas fa-refresh"></i></button>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="accessPointsTable"
                                       class="table table-bordered text-center table-hover nowrap display"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serial.No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Status</th>
                                        <th>Governorate</th>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serial.No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Status</th>
                                        <th>Governorate</th>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
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
            </div>
    </div>
</section>


@include('inventories.access_points_inventories.addAccessPointModal')
@include('inventories.access_points_inventories.editAccessPointModal')
@include('inventories.access_points_inventories.deleteAccessPointModal')
@include('inventories.access_points_inventories.deliverToEmployeeModal')
@include('employees_data.employees.addEmployeeModal')
{{--        End Access Points CRUD                  --}}


@include('inventories.addModelModal')
@include('inventories.addBrandModal')

@endsection
@section("Js_Page")
    @include('inventories.access_points_inventories.accessPointsJS')
    @include('inventories.inventoriesJS')
@endsection



