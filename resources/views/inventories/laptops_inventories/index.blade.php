@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('laptopsLinkActive','active')
@section('page_title','Inventories - Laptops')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Laptops</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Laptops</li>
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
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addLaptopModal">
                            Add New Laptop
                        </button>
                        <a href="{{route('laptops.delivered_laptops_index')}}" class="btn btn-outline-info">
                            Delivered Laptops
                        </a>
                        <button type="button" class="btn btn-outline-secondary" id="refreshLaptopsTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="LaptopsTable" class="table table-bordered table-hover text-center nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial.No</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>CPU</th>
                                    <th>GPU1</th>
                                    <th>GPU2</th>
                                    <th>HDD(GB)</th>
                                    <th>SSD(GB)</th>
                                    <th>RAM</th>
                                    <th>Screen(Inch)</th>
                                    <th>OS</th>
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
                                    <th>CPU</th>
                                    <th>GPU1</th>
                                    <th>GPU2</th>
                                    <th>HDD(GB)</th>
                                    <th>SSD(GB)</th>
                                    <th>RAM</th>
                                    <th>Screen(Inch)</th>
                                    <th>OS</th>
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

@include('inventories.laptops_inventories.addLaptopModal')
@include('inventories.laptops_inventories.editLaptopModal')
@include('inventories.laptops_inventories.deleteLaptopModal')
@include('inventories.laptops_inventories.deliverToEmployeeModal')
@include('employees_data.employees.addEmployeeModal')

{{--        End   Laptops CRUD                  --}}


@include('inventories.addModelModal')
@include('inventories.addCPUModal')
@include('inventories.addGPUModal')
@include('inventories.addBrandModal')
@include('inventories.addOSModal')

@endsection
@section("Js_Page")
    @include('inventories.laptops_inventories.laptopsJS')
    @include('inventories.inventoriesJS')
@endsection

