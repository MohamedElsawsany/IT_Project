<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {



        $('#activitiesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });


        var  table = $("#activitiesTable").DataTable({
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
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('activities.activities')}}",
                type: 'get',
            },
            deferRender: true,
            columns:[
                {data:'id',name:'t1.id'},
                {data:'name',name:'t1.activity_name'},
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
{{-- Edit User Function--}}
        $(document).on('click','#editActivityLink',function(){
            let id = $(this).data('id');
            let activity_name = $(this).data('activityname');
            $('#up_id').val(id);
            $('#upActivityName').val(activity_name);
        });
{{-- END Edit User Function--}}

{{--     delete User      --}}
        $(document).on('click','#deleteActivityBtn',function(e){
            e.preventDefault();
            let id=$('#deleteActivityID').val();
            $.ajax({
                url:"{{ route('activities.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteActivityModal').modal('hide');
                        $('#deleteActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Activity deleted successfully',
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

{{-- view delete name--}}
        $(document).on('click','#deleteActivityLink',function(){
            let activity_name = $(this).data('activityname');
            let id =$(this).data('id');
            $("#deleteActivityName").html(activity_name);
            $('#deleteActivityID').val(id);
        });
{{-- end view delete name--}}

{{-- Add User Function--}}
        $(document).on('click','#addActivityBtn',function(e){
            e.preventDefault();
            let activity_name = $('#activity_name').val();
            $.ajax({
                url:"{{ route('activities.store') }}",
                method:"POST",
                data:{activity_name:activity_name},
                success:function(res){
                    if (res.status=='success') {
                        $('#addActivityModal').modal('hide');
                        $('#addActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Activity added successfully',
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
        $(document).on('click','#updateActivityBtn',function(e){
            e.preventDefault();
            let id=$('#up_id').val();
            let activity_name = $('#upActivityName').val();
            $.ajax({
                url:"{{ route('activities.update') }}",
                method:'put',
                data:{id:id,activity_name:activity_name},
                success:function(res){
                    if (res.status=='success'){
                        $('#editActivityModal').modal('hide');
                        $('#editActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Activity edited successfully',
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





{{--        --}}{{--     rest User password      --}}
{{--        $(document).on('click','#resetPasswordBtn',function(e){--}}
{{--            e.preventDefault();--}}
{{--            let id = $('#resetUserID').val();--}}
{{--            let password = $('#resetPassword').val();--}}
{{--            $.ajax({--}}
{{--                url:"{{ route('users.reset_password') }}",--}}
{{--                method:'put',--}}
{{--                data:{id:id,password:password},--}}
{{--                success:function(res){--}}
{{--                    if (res.status=='success'){--}}
{{--                        $('#resetUserPasswordModal').modal('hide');--}}
{{--                        $('#resetUserPasswordForm')[0].reset();--}}
{{--                        Swal.fire({--}}
{{--                            position: 'center',--}}
{{--                            icon: 'success',--}}
{{--                            title: 'User reset successfully',--}}
{{--                            showConfirmButton: false,--}}
{{--                            timer: 1500--}}
{{--                        });--}}
{{--                        table.ajax.reload( null, false );--}}
{{--                    }else if(res.error){--}}
{{--                        let text = res.error;--}}
{{--                        Swal.fire({--}}
{{--                            icon: 'error',--}}
{{--                            title: 'Oops...',--}}
{{--                            text: text,--}}
{{--                        });--}}
{{--                    }--}}
{{--                },error:function(err){--}}
{{--                    let error = err.responseJSON;--}}
{{--                    $.each(error.errors,function (index,value){--}}
{{--                        toastr.error(value);--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}

{{--        });--}}
{{--        --}}{{--    end reset User oassword     --}}

    });

</script>

