@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('PCsLinkActive','active')
@section('page_title','Inventories - PCs')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">PCs</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">PCs</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{--          PCs CRUD                  --}}
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPCModal">
                            Add New PC
                        </button>

                        <a href="{{route('pcs.delivered_pcs_index')}}" class="btn btn-outline-info">
                            Delivered PCs
                        </a>
                        <button type="button" class="btn btn-outline-secondary" id="refreshPCsTable"><i
                                class="fas fa-refresh"></i>
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="PCsTable"
                                   class="table table-bordered text-center table-hover nowrap display"
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


@include('inventories.PCs_inventories.addPCModal')
@include('inventories.PCs_inventories.editPCModal')
@include('inventories.PCs_inventories.deletePCModal')
@include('inventories.PCs_inventories.deliverToEmployeeModal')
@include('employees_data.employees.addEmployeeModal')

{{--         End  PCs CRUD             --}}


@include('inventories.addModelModal')
@include('inventories.addCPUModal')
@include('inventories.addGPUModal')
@include('inventories.addBrandModal')
@include('inventories.addOSModal')

@endsection
@section("Js_Page")
    @include('inventories.PCs_inventories.PCsJS')
    @include('inventories.inventoriesJS')
@endsection

