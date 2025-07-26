@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('printersLinkActive','active')
@section('page_title','Inventories - Printers')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Printers / Scanners</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Printers & Scanners</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{--        Printers CRUD                  --}}

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addPrinterModal">
                            Add New Printer / Scanner
                        </button>
                        <a href="{{route('printers.delivered_printers_index')}}" class="btn btn-outline-info">
                            Delivered Printers / Scanners
                        </a>
                        <button type="button" class="btn btn-outline-secondary" id="refreshPrintersTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="printersTable"
                                   class="table table-bordered text-center nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial.No</th>
                                    <th>Category</th>
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
                                    <th>Category</th>
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

@include('inventories.printers_inventories.addPrinterModal')
@include('inventories.printers_inventories.editPrinterModal')
@include('inventories.printers_inventories.deletePrinterModal')
@include('inventories.printers_inventories.deliverToEmployeeModal')
@include('employees_data.employees.addEmployeeModal')
{{--        End Printers CRUD                  --}}

@include('inventories.addModelModal')
@include('inventories.addBrandModal')

@endsection
@section("Js_Page")

    @include('inventories.printers_inventories.printersJS')
    @include('inventories.inventoriesJS')

@endsection

