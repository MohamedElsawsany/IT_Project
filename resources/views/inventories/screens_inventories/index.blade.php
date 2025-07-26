@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('screensLinkActive','active')
@section('page_title','Inventories - Screens')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Screens</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Screens</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{--        Screens CRUD                  --}}

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addScreenModal">
                            Add New Screen
                        </button>
                        <a href="{{route('screens.delivered_screens_index')}}" class="btn btn-outline-info">
                            Delivered Screens
                        </a>
                        <button type="button" class="btn btn-outline-secondary" id="refreshScreensTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="screensTable"
                                   class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial.No</th>
                                    <th>Screen(Inch)</th>
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
                                    <th>Screen(Inch)</th>
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

@include('inventories.screens_inventories.addScreenModal')
@include('inventories.screens_inventories.editScreenModal')
@include('inventories.screens_inventories.deleteScreenModal')
@include('inventories.screens_inventories.deliverToEmployeeModal')
@include('employees_data.employees.addEmployeeModal')


{{--        End Screens CRUD                  --}}


@include('inventories.addModelModal')
@include('inventories.addBrandModal')

@endsection
@section("Js_Page")
    @include('inventories.screens_inventories.screensJS')
    @include('inventories.inventoriesJS')
@endsection

