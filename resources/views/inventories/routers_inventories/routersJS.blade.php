<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end Routers datatables function ------------------------------------------}}
        $('#routersTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var routersTable = $("#routersTable").DataTable({
            serverSide: true,
            processing: true,
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
                    },
                    title: 'Routers Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Routers Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('routers.routers')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'brand_name', name: 't2.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'ports', name: 't1.ports'},
                {data: 'flag_name', name: 't9.flag_name'},
                {data: 'governorate_name', name: 't8.governorate_name'},
                {data: 'site_name', name: 't6.site_name'},
                {data: 'activity_name', name: 't7.activity_name'},
                {data: 'creator', name: 't10.name'},
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

        {{--------------------------------- end routers datatables function ------------------------------------------}}

        {{---------------------------------------------- Add router Function -----------------------------------------}}

        $(document).on('click', '#addRouterBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#routerSerialNumber').val();
            let routerBrand = $('#routerBrand').val();
            let routerModel = $('#routerModel').val();
            let routerLocation = $('#routerLocation').val();
            let routerFlag = $('#routerFlag').val();
            let routerPorts = $('#routerPorts').val();
            $.ajax({
                url: "{{ route('routers.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    routerBrand: routerBrand,
                    routerModel: routerModel,
                    routerPorts: routerPorts,
                    routerLocation: routerLocation,
                    routerFlag: routerFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addRouterModal').modal('hide');
                        $('#addRouterForm')[0].reset();
                        $("#routerBrand").select2("val", "0");
                        $("#routerCategory").select2("val", "0");
                        $("#routerModel").select2("val", "0");
                        $("#routerLocation").select2("val", "0");
                        $("#routerFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Router added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        routersTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add Router Function -----------------------------------------}}

        {{----------------------------------------- edit Router model ------------------------------------------------}}

        $(document).on('click', '#editRouterLink', function (e) {
            e.preventDefault();
            let editRouterId = $(this).data('router_id');
            let editRouterSerial = $(this).data('router_serial');
            let editRouterBrand = $(this).data('router_brand');
            let editRouterBrandName = $(this).data('router_brand_name');
            let editRouterModel = $(this).data('router_model');
            let editRouterModelName = $(this).data('router_model_name');
            let editRouterPorts = $(this).data('router_ports');
            let editRouterLocation = $(this).data('router_location');
            let editRouterFlag = $(this).data('router_flag');
            $('#editRouterBrandName').html(editRouterBrandName);
            $('#editRouterModelName').html(editRouterModelName);
            $('#upRouterId').val(editRouterId);
            $('#upRouterSerialNumber').val(editRouterSerial);
            $('#upRouterPorts').val(editRouterPorts);
            $('#upRouterBrand').val(editRouterBrand);
            $('#upRouterBrand').select2().trigger('change');
            $('#upRouterModel').val(editRouterModel);
            $('#upRouterModel').select2().trigger('change');
            $('#upRouterLocation').val(editRouterLocation);
            $('#upRouterLocation').select2().trigger('change');
            $('#upRouterFlag').val(editRouterFlag);
            $('#upRouterFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit router model ------------------------------------------------}}

        {{----------------------------------------------- Update router ----------------------------------------------}}

        $(document).on('click', '#upRouterBtn', function (e) {
            e.preventDefault();
            let upRouterId = $('#upRouterId').val();
            let serial_number = $('#upRouterSerialNumber ').val();
            let upRouterBrand = $('#upRouterBrand').val();
            let upRouterModel = $('#upRouterModel').val();
            let upRouterPorts = $('#upRouterPorts').val();
            let upRouterLocation = $('#upRouterLocation').val();
            let upRouterFlag = $('#upRouterFlag').val();
            $.ajax({
                url: "{{ route('routers.update') }}",
                method: 'put',
                data: {
                    upRouterId: upRouterId,
                    serial_number: serial_number,
                    upRouterBrand: upRouterBrand,
                    upRouterModel: upRouterModel,
                    upRouterPorts: upRouterPorts,
                    upRouterLocation: upRouterLocation,
                    upRouterFlag: upRouterFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editRouterModal').modal('hide');
                        $('#editRouterForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Router edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        routersTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Router --------------------------------------------}}

        {{--------------------------------------- view delete Router model--------------------------------------------}}

        $(document).on('click','#deleteRouterLink',function(e){
            e.preventDefault();
            let id =$(this).data('router_id');
            $('#deleteRouterId').val(id);
        });

        {{--------------------------------------- end view delete Router model----------------------------------------}}

        {{------------------------------------- delete Router function -----------------------------------------------}}

        $(document).on('click','#deleteRouterBtn',function(e){
            e.preventDefault();
            let id=$('#deleteRouterId').val();
            $.ajax({
                url:"{{ route('routers.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteRouterModal').modal('hide');
                        $('#deleteRouterForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Router deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        routersTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete Router function -------------------------------------------}}

        {{-------------------------------------- refresh routers table -----------------------------------------------}}

        $(document).on('click', '#refreshRoutersTable', function (e) {
            e.preventDefault();
            routersTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh routers table -------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('routers.models_store') }}",
                method: "POST",
                data: {model_name:model_name,brand_id:brand_id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#modelBrand').val("0");
                        $('#modelBrand').select2().trigger('change');
                        $('#addModelModal').modal('hide');
                        $('#addModelForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Model added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#routerBrand").select2("val", "0");
                        $("#routerModel").select2("val", "0");
                        $("#upRouterBrand").select2("val", "0");
                        $("#upRouterModel").select2("val", "0");
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

        {{------------------------------------------- End Add Model Function -----------------------------------------}}

        {{------------------------------------------- Dependent Model while adding------------------------------------}}

        $(document).on('change', '#routerBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('routers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#routerModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upRouterBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('routers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upRouterModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{----------------------------------------------- routers Select2 -------------------------------------------------}}

        $('#routerBrand').select2({
            dropdownParent: $('#addRouterModal')
        });
        $('#routerModel').select2({
            dropdownParent: $('#addRouterModal')
        });
        $('#routerLocation').select2({
            dropdownParent: $('#addRouterModal')
        });
        $('#routerFlag').select2({
            dropdownParent: $('#addRouterModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upRouterBrand').select2({
            dropdownParent: $('#editRouterModal')
        });
        $('#upRouterModel').select2({
            dropdownParent: $('#editRouterModal')
        });
        $('#upRouterLocation').select2({
            dropdownParent: $('#editRouterModal')
        });
        $('#upRouterFlag').select2({
            dropdownParent: $('#editRouterModal')
        });

        {{---------------------------------------------- End routers Select2 ----------------------------------------------}}

    });

</script>

