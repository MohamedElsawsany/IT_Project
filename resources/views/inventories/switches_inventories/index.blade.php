@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('switchesLinkActive','active')
@section('page_title','Inventories - Switches')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Switches</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Switches</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{--        Switches CRUD                  --}}

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addSwitchModal">
                            Add New Switch
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="refreshSwitchesTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="switchesTable"
                                   class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial.No</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Ports</th>
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
                                    <th>Ports</th>
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

@include('inventories.switches_inventories.addSwitchModal')
@include('inventories.switches_inventories.editSwitchModal')
@include('inventories.switches_inventories.deleteSwitchModal')
{{--        End Switches CRUD                  --}}


@include('inventories.addModelModal')
@include('inventories.addBrandModal')

@endsection
@section("Js_Page")
    @include('inventories.switches_inventories.switchesJS')
    @include('inventories.inventoriesJS')
@endsection

