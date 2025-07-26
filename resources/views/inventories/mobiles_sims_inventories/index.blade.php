@extends('layouts.it_nassargroup_layout')
@section('inventories_menu','menu-open')
@section('inventoryLinkActive','active')
@section('mobilesLinkActive','active')
@section('page_title','Inventories - mobiles sim')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Mobiles Sim</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventories</li>
            <li class="breadcrumb-item active">Mobiles Sim</li>
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
                                data-target="#addMobileSimModal">
                            Add New Mobile Sim
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="refreshMobilesSimTable"><i
                                class="fas fa-refresh"></i></button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mobilesSimTable"
                                   class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serial.No</th>
                                    <th>Mobile.No</th>
                                    <th>IP</th>
                                    <th>Assigned To</th>
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
                                    <th>Mobile.No</th>
                                    <th>IP</th>
                                    <th>Assigned To</th>
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

@include('inventories.mobiles_sims_inventories.addMobileSimModal')
@include('inventories.mobiles_sims_inventories.editMobileSimModal')
@include('inventories.mobiles_sims_inventories.deleteMobileSimModal')

{{--        End Screens CRUD                  --}}

@endsection
@section("Js_Page")
    @include('inventories.mobiles_sims_inventories.mobilesSimJS')
    @include('inventories.inventoriesJS')
@endsection

