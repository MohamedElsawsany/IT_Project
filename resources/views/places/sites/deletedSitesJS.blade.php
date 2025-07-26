<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {


        $('#deletedSitesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var table = $("#deletedSitesTable").DataTable({
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
                url: "{{route('sites.deleted.sites')}}",
                type: 'get',
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'name', name: 't1.site_name'},
                {data: 'governorate_name', name: 't3.governorate_name'},
                {data: 'creator', name: 't2.name'},
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

         $(document).on('click','#forceDeleteSiteLink',function(){
             let site_name = $(this).data('sitename');
             let id =$(this).data('id');
             $("#forceDeleteSiteName").html(site_name);
             $('#deleteSiteID').val(id);
        });

        {{--delete User--}}
        $(document).on('click','#forceDeleteSiteBtn',function(e){
            e.preventDefault();
            let id=$('#deleteSiteID').val();
            $.ajax({
                url:"{{route('sites.force.delete')}}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#forceDeleteSiteModal').modal('hide');
                        $('#forceDeleteSiteForm')[0].reset();
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
        {{-- end delete User --}}


{{--     restore User      --}}
        $(document).on('click','#restoreDeltedSiteLink',function(e){
            e.preventDefault();
            let id =$(this).data('id');
            $.ajax({
                url:"{{route('sites.restore')}}",
                method:'post',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Site restored successfully',
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
