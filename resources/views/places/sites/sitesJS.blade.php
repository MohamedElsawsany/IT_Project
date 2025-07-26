<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#sitesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var  table = $("#sitesTable").DataTable({
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
                url: "{{route('sites.sites')}}",
                type: 'get',
            },
            deferRender: true,
            columns:[
                {data:'id',name:'t1.id'},
                {data:'name',name:'t1.site_name'},
                {data:'governorate_name',name:'t3.governorate_name'},
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
{{-- Edit Site Function--}}
        $(document).on('click','#editSiteLink',function(){
            let id = $(this).data('id');
            let site_name = $(this).data('site');
            let governorate =$(this).data('governorate');
            $('#up_id').val(id);
            $('#upSiteName').val(site_name);
            $('#upGovernorate').val(governorate);
            $('#upGovernorate').select2().trigger('change');
        });
{{-- END Edit Site Function--}}

{{--     delete Site      --}}
        $(document).on('click','#deleteSiteBtn',function(e){
            e.preventDefault();
            let id=$('#deleteSiteID').val();
            $.ajax({
                url:"{{ route('sites.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteSiteModal').modal('hide');
                        $('#deleteSiteForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site deleted successfully',
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
{{--    end delete Site      --}}

{{-- view delete name--}}
        $(document).on('click','#deleteSiteLink',function(){
            let site_name = $(this).data('sitename');
            let id =$(this).data('id');
            $("#deleteSiteName").html(site_name);
            $('#deleteSiteID').val(id);
        });
{{-- end view delete name--}}

{{-- Add Site Function--}}
        $(document).on('click','#addSiteBtn',function(e){
            e.preventDefault();
            let site_name = $('#site_name').val();
            let governorate =$('#governorate').val();
            $.ajax({
                url:"{{ route('sites.store') }}",
                method:"POST",
                data:{site_name:site_name,governorate:governorate},
                success:function(res){
                    if (res.status=='success') {
                        $('#addSiteModal').modal('hide');
                        $('#addSiteForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#governorate").select2("val", "0");
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
{{--    End Add Site Function   --}}



{{--     Update Site      --}}
        $(document).on('click','#updateSiteBtn',function(e){
            e.preventDefault();
            let id=$('#up_id').val();
            let site_name = $('#upSiteName').val();
            let governorate =$('#upGovernorate').val();
            $.ajax({
                url:"{{ route('sites.update') }}",
                method:'put',
                data:{id:id,site_name:site_name,governorate:governorate},
                success:function(res){
                    if (res.status=='success'){
                        $('#editSiteModal').modal('hide');
                        $('#editSiteForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#governorate").select2("val", "0");
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

        $('#governorate').select2({
            dropdownParent: $('#addSiteModal')
        });

        $('#upGovernorate').select2({
            dropdownParent: $('#editSiteModal')
        });

    });

</script>

