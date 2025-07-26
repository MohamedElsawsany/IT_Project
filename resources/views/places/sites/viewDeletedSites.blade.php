@extends('layouts.it_nassargroup_layout')
@section('sitesLinkActive','active')
@section('placesLinkActive','active')
@section('places_menu','menu-open')
@section('page_title','Sites')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Sites\Deleted</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('sites.index')}}">Sites</a></li>
            <li class="breadcrumb-item active">Deleted</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="deletedSitesTable" class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Site</th>
                                    <th>Governorate</th>
                                    <th>Deleted By</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Deleted Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Site</th>
                                    <th>Governorate</th>
                                    <th>Deleted By</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Deleted Date</th>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('places.sites.forceDeleteSiteModal')
@endsection
@section("Js_Page")
    @include('places.sites.deletedSitesJS')
@endsection

