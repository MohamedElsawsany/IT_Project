<?php
use Illuminate\Support\Carbon;
?>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#employeesDepartmentsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var  table = $("#employeesDepartmentsTable").DataTable({
            serverSide: true,
            processing:true,
            autoWidth:false,
            scrollX:true,
            order: [ [0, 'desc'] ],
            search: {
                return: true
            },
            dom: 'Bftrip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    title: 'Employees Departments Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Employees Departments Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('employees_departments.employees_departments')}}",
                type: 'get',
            },
            deferRender: true,
            columns:[
                {data:'id',name:'t1.id'},
                {data:'department_name',name:'t1.department_name'},
                {data:'creator',name:'t2.name'},
                {data:'created_at',name:'t1.created_at',render: function (value) { return moment(value).format('YYYY-MM-DD');}},
                {data:'updated_at',name:'t1.updated_at',render: function (value) { return moment(value).format('YYYY-MM-DD');}},
                {data:'action',name:'action',searchable:false},
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

{{-- Edit User Function --}}
        $(document).on('click','#editEmployeeDepartmentLink',function(){
            let id = $(this).data('id');
            let department_name = $(this).data('departmentname');
            $('#up_id').val(id);
            $('#upEmployeeDepartmentName').val(department_name);
        });
{{-- END Edit User Function --}}

{{--     delete User      --}}
        $(document).on('click','#deleteEmployeeDepartmentBtn',function(e){
            e.preventDefault();
            let id=$('#deleteEmployeeDepartmentID').val();
            $.ajax({
                url:"{{ route('employees_departments.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteEmployeeDepartmentModal').modal('hide');
                        $('#deleteEmployeeDepartmentForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Department deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload( null, false );
                    }else if(res.error){
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });
                    }
                },error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function (index,value){
                        toastr.error(value);
                    });
                }
            });

        });
{{--    end delete User      --}}

{{-- view delete name --}}
        $(document).on('click','#deleteEmployeeDepartmentLink',function(){
            let department_name = $(this).data('departmentname');
            let id =$(this).data('id');
            $("#deleteEmployeeDepartmentName").html(department_name);
            $('#deleteEmployeeDepartmentID').val(id);
        });
{{-- end view delete name--}}

{{-- Add User Function--}}
        $(document).on('click','#addEmployeeDepartmentBtn',function(e){
            e.preventDefault();
            let department_name = $('#department_name').val();
            $.ajax({
                url:"{{ route('employees_departments.store') }}",
                method:"POST",
                data:{department_name:department_name},
                success:function(res){
                    if (res.status=='success') {
                        $('#addEmployeeDepartmentModal').modal('hide');
                        $('#addEmployeeDepartmentForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Department added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload(null, false);
                    }else if(res.error){
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });

                    }
                },error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function (index,value){
                        toastr.error(value);
                    });
                }
            });

        });
{{--    End Add User Function   --}}



{{--     Update User      --}}
        $(document).on('click','#updateEmployeeDepartmentBtn',function(e){
            e.preventDefault();
            let id=$('#up_id').val();
            let department_name=$('#upEmployeeDepartmentName').val();
            $.ajax({
                url:"{{ route('employees_departments.update') }}",
                method:'put',
                data:{id:id,department_name:department_name},
                success:function(res){
                    if (res.status=='success'){
                        $('#editEmployeeDepartmentModal').modal('hide');
                        $('#editEmployeeDepartmentForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Department edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload( null, false );
                    }else if(res.error){
                        let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });

                    }
                },error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function (index,value){
                        toastr.error(value);
                    });
                }
            });

        });
{{--    End Update Site      --}}


    });

</script>

