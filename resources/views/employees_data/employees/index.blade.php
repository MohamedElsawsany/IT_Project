@extends('layouts.it_nassargroup_layout')
@section('employeesLinkActive','active')
@section('employeesDataLinkActive','active')
@section('employeesData_menu','menu-open')
@section('page_title','Employees')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Employees</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Employees</li>
        </ol>
    </div><!-- /.col -->

@endsection
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addEmployeeModal">
                            Add New Employee
                        </button>
{{--                        <a href="{{route('employees.view.deleted.index')}}" class="btn btn-outline-dark"><i--}}
{{--                                class="fas fa-trash-restore"></i></a>--}}
                        <button type="button" class="btn btn-outline-secondary" id="refreshEmployeesTable"><i
                                class="fas fa-refresh"></i></button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="employeesTable"
                                   class="table table-bordered text-center table-hover nowrap display">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Department</th>
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
                                    <th>Employee</th>
                                    <th>Department</th>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@include('employees_data.employees.addEmployeeModal')
@include('employees_data.employees.editEmployeeModal')
@include('employees_data.employees.deleteEmployeeModal')

@endsection
@section("Js_Page")
    @include('employees_data.employees.employeesJS')
@endsection

