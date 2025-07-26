<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#usersTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var  table = $("#usersTable").DataTable({
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
                url: "{{route('users.users')}}",
                type: 'post',
            },
            deferRender: true,
            columns:[
                {data:'id',name:'t1.id'},
                {data:'name',name:'t1.name'},
                {data:'email',name:'t1.email'},
                {data:'role_name',name:'t4.role_name'},
                {data:'site_name',name:'t3.site_name'},
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
        $(document).on('click','#editUserLink',function(){
            let id = $(this).data('id');
            let name = $(this).data('username');
            let email =$(this).data('email');
            let role = $(this).data('role');
            let site =$(this).data('site');
            $('#up_id').val(id);
            $('#upUsername').val(name);
            $('#upEmail').val(email);
            $('#upUserRole').val(role);
            $('#upUserRole').select2().trigger('change');
            $('#upUserSite').val(site);
            $('#upUserSite').select2().trigger('change');
        });
        {{-- END Edit User Function--}}


        {{-- view Users--}}
        $(document).on('click','#viewUserLink',function(){
            let name = $(this).data('username');
            let email =$(this).data('email');
            let role = $(this).data('role');
            let site =$(this).data('site');
            let creator=$(this).data('createdby');
            let createdDate=$(this).data('createdat');
            let updatedDate=$(this).data('updatedat');
            $('#viewUsername').val(name);
            $('#viewEmail').val(email);
            $('#viewUserRole').val(role);
            $('#viewUserSite').val(site);
            $('#viewCreatedDate').val(createdDate);
            $('#viewUpdatedDate').val(updatedDate);
            $('#viewCreatedBy').val(creator);

        });
        {{--  end view users --}}

        {{-- view delete name--}}
                    $(document).on('click','#deleteUserLink',function(){
                        let name = $(this).data('username');
                        let id =$(this).data('id');
                        $("#deleteUserName").html(name);
                        $('#deleteUserID').val(id);
                    });
        {{-- end view delete name--}}



        {{-- set id when password reset --}}

                $(document).on('click','#resetUserPasswordLink',function (e){
                    e.preventDefault();
                        let id = $(this).data('id');
                            $('#resetUserID').val(id);
                });

        {{--  end reset User Password  --}}


        {{--    Add User Function    --}}
    $(document).on('click','#addUserBtn',function(e){
        e.preventDefault();
        let username = $('#user_name').val();
        let email =$('#email').val();
        let password = $('#password').val();
        let user_role = $('#user_role').val();
        let user_site =$('#user_site').val();

            $.ajax({
                url:"{{ route('users.store') }}",
                method:"POST",
                data:{username:username,email:email,password:password,user_role:user_role,user_site:user_site},
                success:function(res){
                    if (res.status=='success') {
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#user_role").select2("val", "0");
                        $("#user_site").select2("val", "0");
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
    $(document).on('click','#updateUserBtn',function(e){
        e.preventDefault();
        let id=$('#up_id').val();
        let username = $('#upUsername').val();
        let email =$('#upEmail').val();
        let role = $('#upUserRole').val();
        let site =$('#upUserSite').val();
        $.ajax({
            url:"{{ route('users.update') }}",
            method:'put',
            data:{id:id,username:username,email:email,role:role,site:site},
            success:function(res){
                if (res.status=='success'){
                    $('#editUserModal').modal('hide');
                    $('#editUserForm')[0].reset();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'User edited successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#upUserRole").select2("val", "0");
                    $("#upUserSite").select2("val", "0");
                    table.ajax.reload( null, false );
                }else if(res.error){
                    let text = res.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: text,
                        });
                }else if(res.redirection = 'true'){
                    window.location.href = "/";
                }
            },error:function(err){
                let error = err.responseJSON;
                $.each(error.errors,function (index,value){
                    toastr.error(value);
                });
            }
        });

    });
        {{--    end Update User      --}}


        {{--     delete User      --}}
        $(document).on('click','#deleteUserBtn',function(e){
            e.preventDefault();
            let id=$('#deleteUserID').val();
            $.ajax({
                url:"{{ route('users.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteUserModal').modal('hide');
                        $('#deleteUserForm')[0].reset();
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
                    }else if(res.delete_self_error == 'true'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You cannot delete your self',
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


        {{--     rest User password      --}}
        $(document).on('click','#resetPasswordBtn',function(e){
            e.preventDefault();
            let id = $('#resetUserID').val();
            let password = $('#resetPassword').val();
            $.ajax({
                url:"{{ route('users.reset_password') }}",
                method:'put',
                data:{id:id,password:password},
                success:function(res){
                    if (res.status=='success'){
                        $('#resetUserPasswordModal').modal('hide');
                        $('#resetUserPasswordForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User reset successfully',
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
                    }else if(res.redirection == 'true'){
                        window.location.href = "/";
                    }
                },error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function (index,value){
                        toastr.error(value);
                    });
                }
            });

        });
        {{--    end reset User oassword     --}}


        ;$('#user_role').select2({
            dropdownParent: $('#addUserModal')
        });

        $('#user_site').select2({
            dropdownParent: $('#addUserModal')
        });

        ;$('#upUserRole').select2({
            dropdownParent: $('#editUserModal')
        });

        $('#upUserSite').select2({
            dropdownParent: $('#editUserModal')
        });



    });











{{-- crud functions--}}
{{-- $(function (){--}}







{{--});--}}
{{-- end crud functions--}}

{{-- table function--}}
// $('#usersTable').DataTable( {
//     dom: 'Bfrtip',
//     scrollX:true,
//     lengthMenu: [
//         [ 10, 25, 50, -1 ],
//         [ '10 rows', '25 rows', '50 rows', 'Show all' ]
//     ],
//     buttons: [
//         'pageLength',
//         {
//             extend: 'copyHtml5',
//             exportOptions: {
//                 columns: [ 0, ':visible' ]
//             }
//         },
//         {
//             extend: 'excelHtml5',
//             exportOptions: {
//                 columns: ':visible'
//             }
//         },
//         {
//             extend: 'pdfHtml5',
//             exportOptions: {
//                 columns: ':visible'
//             }
//         },
//         {
//             extend: 'print',
//             exportOptions: {
//                 columns: ':visible'
//             },
//             title: 'Users Information'
//         },
//         'colvis'
//     ]
// } );
{{-- end table function--}}






{{--notifications--}}
{{--    @if(session('adding_message_success'))--}}
{{--        Swal.fire({--}}
{{--            position: 'center',--}}
{{--            icon: 'success',--}}
{{--            title: 'User added successfully',--}}
{{--            showConfirmButton: false,--}}
{{--            timer: 1500--}}
{{--        });--}}
{{--    @endif--}}

{{--    @if(session('adding_message_sql'))--}}
{{--        Swal.fire({--}}
{{--            icon: 'error',--}}
{{--            title: 'Oops...',--}}
{{--            text: 'Error',--}}
{{--        });--}}
{{--    @endif--}}

{{--    @if (count($errors) > 0)--}}
{{--        $('#addUserModal').modal('show');--}}
{{--    @endif--}}


</script>

