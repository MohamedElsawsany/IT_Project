@extends('layouts.it_nassargroup_layout')
@section('employeesDepartmentsLinkActive','active')
@section('employeesDataLinkActive','active')
@section('employeesData_menu','menu-open')
@section('page_title','Employees Departments')
@section('pageContent')
@section('content_header')

    <div class="col-sm-6">
        <h1 class="m-0">Employees Departments</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Employees Departments</li>
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
                                data-target="#addEmployeeDepartmentModal">
                            Add New Department
                        </button>
{{--                        <a href="{{route('employees_departments.view.deleted.index')}}" class="btn btn-outline-dark"><i--}}
{{--                                class="fas fa-trash-restore"></i></a>--}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="employeesDepartmentsTable"
                                   class="table table-bordered text-center table-hover nowrap display"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
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

@include('employees_data.employees_departments.addEmployeeDepartmentModal')
@include('employees_data.employees_departments.editEmployeeDepartmentModal')
@include('employees_data.employees_departments.deleteEmployeeDepartmentModal')

@endsection
@section("Js_Page")
    @include('employees_data.employees_departments.employeesDepartmentsJS')
@endsection


