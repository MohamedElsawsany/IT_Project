<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {



        $('#deletedUsersTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var table = $("#deletedUsersTable").DataTable({
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
                url: "{{route('users.deleted.users')}}",
                type: 'get',
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'name', name: 't1.name'},
                {data: 'email', name: 't1.email'},
                {data: 'role_name', name: 't4.role_name'},
                {data: 'site_name', name: 't3.site_name'},
                {data: 'creator', name: 't2.name'},
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

        $(document).on('click','#forceDeleteUserLink',function(){
            let name = $(this).data('username');
            let id =$(this).data('id');
            $("#forceDeleteUserName").html(name);
            $('#deleteUserID').val(id);
        });

        {{--     delete User      --}}
        $(document).on('click','#forceDeleteUserBtn',function(e){
            e.preventDefault();
            let id=$('#deleteUserID').val();
            $.ajax({
                url:"{{route('users.force.delete')}}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#forceDeleteUserModal').modal('hide');
                        $('#forceDeleteUserForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User deleted successfully',
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


        {{--     restore User      --}}
        $(document).on('click','#restoreDeltedUserLink',function(e){
            e.preventDefault();
            let id =$(this).data('id');
            $.ajax({
                url:"{{route('users.restore')}}",
                method:'post',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User restored successfully',
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
