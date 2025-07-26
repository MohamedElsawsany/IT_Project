<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        {{----------------------------------------- servers datatables function --------------------------------------}}
        $('#serversTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });
        var serversTable = $("#serversTable").DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX:true,
            order: [ [0, 'desc'] ],
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
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    },
                    title: 'Servers Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Servers Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('servers.servers')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'brand_name', name: 't2.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'cpu_name', name: 't4.cpu_name'},
                {data: 'gpu1_name', name: 't5.gpu_name'},
                {data: 'gpu2_name', name: 't6.gpu_name'},
                {data: 'hdd_storage', name: 't1.hdd_storage'},
                {data: 'ssd_storage', name: 't1.ssd_storage'},
                {data: 'ram', name: 't1.ram'},
                {data: 'os_name', name: 't13.os_name'},
                {data: 'flag_name', name: 't7.flag_name'},
                {data: 'governorate_name', name: 't12.governorate_name'},
                {data: 'site_name', name: 't10.site_name'},
                {data: 'activity_name', name: 't11.activity_name'},
                {data: 'creator', name: 't8.name'},
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

        {{---------------------------------------- End servers datatables function -----------------------------------}}




        {{--------------------------------------------- Edit Server modal --------------------------------------------}}

        $(document).on('click', '#editServerLink', function (e) {
            e.preventDefault();
            let editServerId = $(this).data('server_id');
            let editServerSerial = $(this).data('server_serial');
            let editServerBrand = $(this).data('server_brand');
            let editServerBrandName = $(this).data('server_brand_name');
            let editServerModel = $(this).data('server_model');
            let editServerModelName = $(this).data('server_model_name');
            let editServerCPU = $(this).data('server_cpu');
            let editServerGPU1 = $(this).data('server_gpu1');
            let editServerGPU2 = $(this).data('server_gpu2');
            let editServerOS = $(this).data('server_os');
            let editServerHDD = $(this).data('server_hdd');
            let editServerSSD = $(this).data('server_ssd');
            let editServerRam = $(this).data('server_ram');
            let editServerLocation = $(this).data('server_location');
            let editServerFlag = $(this).data('server_flag');
            $('#editServerBrandName').html(editServerBrandName);
            $('#editServerModelName').html(editServerModelName);
            $('#upServerId').val(editServerId);
            $('#upServerSerialNumber').val(editServerSerial);
            $('#upServerBrand').val(editServerBrand);
            $('#upServerBrand').select2().trigger('change');
            $('#upServerModel').val(editServerModel);
            $('#upServerModel').select2().trigger('change');
            $('#upServerCPU').val(editServerCPU);
            $('#upServerCPU').select2().trigger('change');
            $('#upServerGPU1').val(editServerGPU1);
            $('#upServerGPU1').select2().trigger('change');
            $('#upServerGPU2').val(editServerGPU2);
            $('#upServerGPU2').select2().trigger('change');
            $('#upServerLocation').val(editServerLocation);
            $('#upServerLocation').select2().trigger('change');
            $('#upServerOS').val(editServerOS);
            $('#upServerOS').select2().trigger('change');
            $('#upServerFlag').val(editServerFlag);
            $('#upServerFlag').select2().trigger('change');
            $('#upServerHDDStorage').val(editServerHDD);
            $('#upServerSSDStorage').val(editServerSSD);
            $('#upServerRam').val(editServerRam);
        });

        {{---------------------------------------- END edit server modal ---------------------------------------------}}





        {{----------------------------------------------- delete Server ----------------------------------------------}}

        $(document).on('click', '#deleteServerBtn', function (e) {
            e.preventDefault();
            let id = $('#deleteServerId').val();
            $.ajax({
                url: "{{ route('servers.soft_delete') }}",
                method: 'delete',
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deleteServerModal').modal('hide');
                        $('#deleteServerForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Server deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        serversTable.ajax.reload(null, false);
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

        {{---------------------------------------------- end delete Server -------------------------------------------}}




        {{-------------------------------------------- refresh servers table -----------------------------------------}}

        $(document).on('click', '#refreshServersTable', function (e) {
            e.preventDefault();
            serversTable.ajax.reload(null, false);
        });

        {{------------------------------------------ end refresh servers table ---------------------------------------}}




        {{-------------------------------------------- view server delete modal --------------------------------------}}

        $(document).on('click', '#deleteServerLink', function (e) {
            e.preventDefault();
            let id = $(this).data('server_id');
            $('#deleteServerId').val(id);
        });

        {{-------------------------------------------- end view server delete modal ----------------------------------}}




        {{---------------------------------------------- Add Server Function -----------------------------------------}}
        $(document).on('click', '#addServerBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#serverSerialNumber').val();
            let serverBrand = $('#serverBrand').val();
            let serverModel = $('#serverModel').val();
            let serverCPU = $('#serverCPU').val();
            let serverGPU1 = $('#serverGPU1').val();
            let serverGPU2 = $('#serverGPU2').val();
            let serverHDDStorage = $('#serverHDDStorage').val();
            let serverSSDStorage = $('#serverSSDStorage').val();
            let serverLocation = $('#serverLocation').val();
            let serverRam = $('#serverRam').val();
            let serverFlag = $('#serverFlag').val();
            let serverOS = $('#serverOS').val();
            $.ajax({
                url: "{{ route('servers.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    serverBrand: serverBrand,
                    serverModel: serverModel,
                    serverCPU: serverCPU,
                    serverGPU1: serverGPU1,
                    serverGPU2: serverGPU2,
                    serverHDDStorage: serverHDDStorage,
                    serverSSDStorage: serverSSDStorage,
                    serverLocation: serverLocation,
                    serverRam: serverRam,
                    serverFlag: serverFlag,
                    serverOS: serverOS
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addServerModal').modal('hide');
                        $('#addServerForm')[0].reset();
                        $("#serverBrand").select2("val", "0");
                        $("#serverModel").select2("val", "0");
                        $("#serverOS").select2("val", "0");
                        $("#serverCPU").select2("val", "0");
                        $("#serverGPU1").select2("val", "0");
                        $("#serverGPU2").select2("val", "0");
                        $("#serverLocation").select2("val", "0");
                        $("#serverFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Server added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        serversTable.ajax.reload(null, false);
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

        {{------------------------------------------- End Add Server Function ----------------------------------------}}




        {{---------------------------------------------- Update Server -----------------------------------------------}}

        $(document).on('click', '#upServerBtn', function (e) {
            e.preventDefault();
            let upServerId = $('#upServerId').val();
            let serial_number = $('#upServerSerialNumber ').val();
            let upServerBrand = $('#upServerBrand').val();
            let upServerModel = $('#upServerModel').val();
            let upServerCPU = $('#upServerCPU').val();
            let upServerRam = $('#upServerRam').val();
            let upServerGPU1 = $('#upServerGPU1').val();
            let upServerGPU2 = $('#upServerGPU2').val();
            let upServerOS = $('#upServerOS').val();
            let upServerFlag = $('#upServerFlag').val();
            let upServerHDDStorage = $('#upServerHDDStorage').val();
            let upServerSSDStorage = $('#upServerSSDStorage').val();
            let upServerLocation = $('#upServerLocation').val();
            $.ajax({
                url: "{{ route('servers.update') }}",
                method: 'put',
                data: {
                    upServerId: upServerId,
                    serial_number: serial_number,
                    upServerBrand: upServerBrand,
                    upServerModel: upServerModel,
                    upServerCPU: upServerCPU,
                    upServerRam: upServerRam,
                    upServerGPU1: upServerGPU1,
                    upServerGPU2: upServerGPU2,
                    upServerFlag: upServerFlag,
                    upServerHDDStorage: upServerHDDStorage,
                    upServerSSDStorage: upServerSSDStorage,
                    upServerOS: upServerOS,
                    upServerLocation: upServerLocation
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editServerModal').modal('hide');
                        $('#editServerForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Server edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        serversTable.ajax.reload(null, false);
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

        {{----------------------------------------- End Update Server ------------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('servers.models_store') }}",
                method: "POST",
                data: {model_name: model_name, brand_id: brand_id},
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
                        $("#serverBrand").select2("val", "0");
                        $("#serverModel").select2("val", "0");
                        $("#upServerBrand").select2("val", "0");
                        $("#upServerModel").select2("val", "0");
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

        $(document).on('change', '#serverBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('servers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#serverModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upServerBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('servers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upServerModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{--------------------------------------------- Server Select2 -----------------------------------------------}}

        $('#serverBrand').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverModel').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverCPU').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverGPU1').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverGPU2').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverLocation').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverOS').select2({
            dropdownParent: $('#addServerModal')
        });
        $('#serverFlag').select2({
            dropdownParent: $('#addServerModal')
        });

        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });


        $('#upServerBrand').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerModel').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerCPU').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerGPU1').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerGPU2').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerLocation').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerOS').select2({
            dropdownParent: $('#editServerModal')
        });
        $('#upServerFlag').select2({
            dropdownParent: $('#editServerModal')
        });

        {{--------------------------------------------- End Server Select2 -------------------------------------------}}
    });

</script>

