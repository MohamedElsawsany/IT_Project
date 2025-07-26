<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#deletedEmployeesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var table = $("#deletedEmployeesTable").DataTable({
            serverSide: true,
            processing: true,
            autoWidth:false,
            scrollX:true,
            order: [ [0, 'desc'] ],
            search: {
                return: true
            },
            dom: 'ftrip',
            ajax: {
                url: "{{route('employees.deleted.employees')}}",
                type: 'get',
            },
            deferRender: true,
            columns: [
                {data:'id',name:'t1.id'},
                {data:'emp_name',name:'t1.emp_name'},
                {data:'department_name',name:'t3.department_name'},
                {data:'creator',name:'t2.name'},
                {data: 'created_at', name: 't1.created_at',render: function (value) { return moment(value).format('YYYY-MM-DD');}},
                {data: 'updated_at', name: 't1.created_at',render: function (value) { return moment(value).format('YYYY-MM-DD');}},
                {data: 'deleted_at', name: 't1.deleted_at'},
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

         $(document).on('click','#forceDeleteEmployeeLink',function(){
             let emp_name = $(this).data('empname');
             let id =$(this).data('id');
             $("#forceDeleteEmployeeName").html(emp_name);
             $('#deleteEmployeeID').val(id);
        });

{{--delete User--}}
        $(document).on('click','#forceDeleteEmployeeBtn',function(e){
            e.preventDefault();
            let id=$('#deleteEmployeeID').val();
            $.ajax({
                url:"{{route('employees.force.delete')}}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#forceDeleteEmployeeModal').modal('hide');
                        $('#forceDeleteEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee deleted successfully',
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
{{-- end delete User --}}


{{--     restore User      --}}
        $(document).on('click','#restoreDeltedEmployeeLink',function(e){
            e.preventDefault();
            let id =$(this).data('id');
            $.ajax({
                url:"{{route('employees.restore')}}",
                method:'post',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee restored successfully',
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
{{--    end restore User      --}}



    });
</script>
