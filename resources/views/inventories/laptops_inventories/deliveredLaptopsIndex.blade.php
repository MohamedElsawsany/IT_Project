@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('laptopsLinkActive','active')
@section('page_title','Inventories - Delivered Laptops')
@section('pageContent')
    @section('content_header')

        <div class="col-sm-6">
            <h1 class="m-0">Delivered Laptops</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Inventories</li>
                <li class="breadcrumb-item"><a href="{{route('laptops.index')}}">Laptops</a></li>
                <li class="breadcrumb-item active">Delivered Laptops</li>
            </ol>
        </div><!-- /.col -->

    @endsection
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    {{--          Laptops CRUD                  --}}

                    <div class="card">
                        <div class="card-header">
                                <button type="button" class="btn btn-outline-secondary" id="refreshDeliveredLaptopsTable"><i
                                        class="fas fa-refresh"></i>
                                </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="deliveredLaptopsTable"
                                       class="table table-bordered table-hover text-center nowrap display"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serial</th>
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
                                        <th>Serial</th>
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
    @include('inventories.laptops_inventories.deliveredLaptopsJS')
@endsection

