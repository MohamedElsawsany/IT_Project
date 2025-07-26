<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#sitesActivitiesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var  table = $("#sitesActivitiesTable").DataTable({
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
                url: "{{route('sites_activities.sites_activities')}}",
                type: 'get',
            },
            deferRender: true,
            columns:[
                {data:'id',name:'t1.id'},
                {data:'governorate_name',name:'t5.governorate_name'},
                {data:'site_name',name:'t3.site_name'},
                {data:'activity_name',name:'t4.activity_name'},
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
{{-- Edit Site Activity Function--}}
        $(document).on('click','#editSiteActivityLink',function(){
            let id = $(this).data('id');
            let site_name = $(this).data('siteid');
            let activity_name =$(this).data('activityid');
            $('#up_id').val(id);
            $('#upSiteName').val(site_name);
            $('#upSiteName').select2().trigger('change');
            $('#upActivityName').val(activity_name);
            $('#upActivityName').select2().trigger('change');
        });
{{-- END Edit Site Activity Function--}}

{{--     delete Site Activity      --}}
        $(document).on('click','#deleteSiteActivityBtn',function(e){
            e.preventDefault();
            let id=$('#deleteSiteActivityID').val();
            $.ajax({
                url:"{{ route('sites_activities.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteSiteActivityModal').modal('hide');
                        $('#deleteSiteActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site activity deleted successfully',
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
{{--    end delete Site Activity      --}}

{{-- view delete name--}}
        $(document).on('click','#deleteSiteActivityLink',function(){
            let site_activity_name = $(this).data('siteactivityname');
            let id =$(this).data('id');
            $("#deleteSiteActivityName").html(site_activity_name);
            $('#deleteSiteActivityID').val(id);
        });
{{-- end view delete name--}}

{{-- Add Site Activity Function--}}
        $(document).on('click','#addSiteActivityBtn',function(e){
            e.preventDefault();
            let site_name = $('#site_name').val();
            let activity_name =$('#activity_name').val();
            $.ajax({
                url:"{{ route('sites_activities.store') }}",
                method:"POST",
                data:{site_name:site_name,activity_name:activity_name},
                success:function(res){
                    if (res.status=='success') {
                        $('#addSiteActivityModal').modal('hide');
                        $('#addSiteActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#site_name").select2("val", "0");
                        $("#activity_name").select2("val", "0");
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
{{--    End Add Site Activity Function   --}}



{{--     Update Site Activity      --}}
        $(document).on('click','#updateSiteActivityBtn',function(e){
            e.preventDefault();
            let id=$('#up_id').val();
            let site_name = $('#upSiteName').val();
            let activity_name =$('#upActivityName').val();
            $.ajax({
                url:"{{ route('sites_activities.update') }}",
                method:'put',
                data:{id:id,site_name:site_name,activity_name:activity_name},
                success:function(res){
                    if (res.status=='success'){
                        $('#editSiteActivityModal').modal('hide');
                        $('#editSiteActivityForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site activity edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#site_name").select2("val", "0");
                        $("#activity_name").select2("val", "0");
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
{{--    End Update Site Activity      --}}
        $('#site_name').select2({
            dropdownParent: $('#addSiteActivityModal')
        });
        $('#activity_name').select2({
            dropdownParent: $('#addSiteActivityModal')
        });

        $('#upSiteName').select2({
            dropdownParent: $('#editSiteActivityModal')
        });
        $('#upActivityName').select2({
            dropdownParent: $('#editSiteActivityModal')
        });

    });

</script>

