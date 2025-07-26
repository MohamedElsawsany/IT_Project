@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('serversLinkActive','active')
@section('page_title','Inventories - Servers')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Servers</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Servers</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{--        Servers CRUD                  --}}

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addServerModal">
                            Add New Server
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="refreshServersTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="serversTable"
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

@include('inventories.servers_inventories.addServerModal')
@include('inventories.servers_inventories.editServerModal')
@include('inventories.servers_inventories.deleteServerModal')

{{--        End Servers CRUD                  --}}


@include('inventories.addModelModal')
@include('inventories.addCPUModal')
@include('inventories.addGPUModal')
@include('inventories.addBrandModal')
@include('inventories.addOSModal')

@endsection
@section("Js_Page")
    @include('inventories.servers_inventories.serversJS')
    @include('inventories.inventoriesJS')
@endsection

