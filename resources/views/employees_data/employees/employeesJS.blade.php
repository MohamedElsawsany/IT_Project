<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        $('#employeesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var table = $("#employeesTable").DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX: true,
            order: [[0, 'desc']],
            search: {
                return: true
            },
            dom: 'Bftrip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, ':visible']
                    },
                    title: 'Employees  Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Employees  Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('employees.employees')}}",
                type: 'get',
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'emp_name', name: 't1.emp_name'},
                {data: 'department_name', name: 't3.department_name'},
                {data: 'creator', name: 't2.name'},
                {
                    data: 'created_at', name: 't1.created_at', render: function (value) {
                        return moment(value).format('YYYY-MM-DD');
                    }
                },
                {
                    data: 'updated_at', name: 't1.updated_at', render: function (value) {
                        return moment(value).format('YYYY-MM-DD');
                    }
                },
                {data: 'action', name: 'action', searchable: false},
            ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var that = this;
                        $('input', this.footer()).on('submit change clear', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                    });
            }, fixedColumns: {
                left: 0,
                right: 1
            }
        });

        {{-- Edit Employee Function --}}
        $(document).on('click', '#editEmployeeLink', function () {
            let id = $(this).data('id');
            let emp_name = $(this).data('emp_name');
            let emp_department = $(this).data('emp_department');
            $('#up_id').val(id);
            $('#upEmployeeName').val(emp_name);
            $('#upDepartmentName').val(emp_department);
            $('#upDepartmentName').select2().trigger('change');
        });

        {{-- END Edit Employee Function --}}

        {{--     delete Employee      --}}
        $(document).on('click', '#deleteEmployeeBtn', function (e) {
            e.preventDefault();
            let id = $('#deleteEmployeeID').val();
            $.ajax({
                url: "{{ route('employees.soft_delete') }}",
                method: 'delete',
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deleteEmployeeModal').modal('hide');
                        $('#deleteEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload(null, false);
                    } else if (res.error) {
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });
                    }
                }, error: function (err) {
                    let error = err.responseJSON;
                    $.each(error.errors, function (index, value) {
                        toastr.error(value);
                    });
                }
            });

        });
        {{--    end delete Employee      --}}


        {{--  refresh table  --}}

        $(document).on('click', '#refreshEmployeesTable', function (e) {
            e.preventDefault();
            table.ajax.reload(null, false);
        });
        {{--    end refresh table      --}}

        {{-- view delete name --}}
        $(document).on('click', '#deleteEmployeeLink', function () {
            let emp_name = $(this).data('empname');
            let id = $(this).data('id');
            $("#deleteEmployeeName").html(emp_name);
            $('#deleteEmployeeID').val(id);
        });
        {{-- end view delete name--}}

        {{-- Add Employee Function--}}
        $(document).on('click', '#addEmployeeBtn', function (e) {
            e.preventDefault();
            let employee_name = $('#employee_name').val();
            let departmentName = $('#departmentName').val();
            $.ajax({
                url: "{{ route('employees.store') }}",
                method: "POST",
                data: {employee_name: employee_name,departmentName:departmentName},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addEmployeeModal').modal('hide');
                        $('#addEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#departmentName").select2("val", "0");
                        table.ajax.reload(null, false);
                    } else if (res.error) {
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });

                    }
                }, error: function (err) {
                    let error = err.responseJSON;
                    $.each(error.errors, function (index, value) {
                        toastr.error(value);
                    });
                }
            });

        });
        {{--    End Add Employee Function   --}}



        {{--     Update Employee      --}}
        $(document).on('click', '#updateEmployeeBtn', function (e) {
            e.preventDefault();
            let id = $('#up_id').val();
            let emp_name = $('#upEmployeeName').val();
            let upDepartmentName = $('#upDepartmentName').val();
            $.ajax({
                url: "{{ route('employees.update') }}",
                method: 'put',
                data: {id: id, emp_name: emp_name, upDepartmentName: upDepartmentName},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editEmployeeModal').modal('hide');
                        $('#editEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#upDepartmentName").select2("val", "0");
                        table.ajax.reload(null, false);
                    } else if (res.error) {
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });

                    }
                }, error: function (err) {
                    let error = err.responseJSON;
                    $.each(error.errors, function (index, value) {
                        toastr.error(value);
                    });
                }
            });

        });
        {{--    End Update Employee      --}}


        $('#departmentName').select2({
            dropdownParent: $('#addEmployeeModal')
        });


        $('#upDepartmentName').select2({
            dropdownParent: $('#editEmployeeModal')
        });


    });

</script>

