@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('screensLinkActive','active')
@section('page_title','Inventories - Delivered Screens')
@section('pageContent')
    @section('content_header')

        <div class="col-sm-6">
            <h1 class="m-0">Delivered Screens</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Inventories</li>
                <li class="breadcrumb-item"><a href="{{route('screens.index')}}">Screens</a></li>
                <li class="breadcrumb-item active">Delivered Screens</li>
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
                                <button type="button" class="btn btn-outline-secondary" id="refreshDeliveredScreensTable"><i
                                        class="fas fa-refresh"></i></button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="deliveredScreensTable"
                                       class="table table-bordered disabled text-center nowrap display"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serial.No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Delivered To</th>
                                        <th>Department</th>
                                        <th>Governorate</th>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Delivered By</th>
                                        <th>Backed By</th>
                                        <th>Delivered Date</th>
                                        <th>Backed To Stock Date</th>
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
                                        <th>Delivered To</th>
                                        <th>Department</th>
                                        <th>Governorate</th>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Delivered By</th>
                                        <th>Backed By</th>
                                        <th>Delivered Date</th>
                                        <th>Backed To Stock Date</th>
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

@endsection
@section("Js_Page")
    @include('inventories.screens_inventories.deliveredScreensJS')
@endsection

