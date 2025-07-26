<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end switches datatables function ------------------------------------------}}
        $('#switchesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var switchesTable = $("#switchesTable").DataTable({
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
                    title: 'Switches Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Switches Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('switches.switches')}}",
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

        {{--------------------------------- end switches datatables function ------------------------------------------}}

        {{---------------------------------------------- Add switch Function -----------------------------------------}}

        $(document).on('click', '#addSwitchBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#switchSerialNumber').val();
            let switchBrand = $('#switchBrand').val();
            let switchModel = $('#switchModel').val();
            let switchPorts = $('#switchPorts').val();
            let switchLocation = $('#switchLocation').val();
            let switchFlag = $('#switchFlag').val();
            $.ajax({
                url: "{{ route('switches.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    switchBrand: switchBrand,
                    switchModel: switchModel,
                    switchPorts: switchPorts,
                    switchLocation: switchLocation,
                    switchFlag: switchFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addSwitchModal').modal('hide');
                        $('#addSwitchForm')[0].reset();
                        $("#switchBrand").select2("val", "0");
                        $("#switchCategory").select2("val", "0");
                        $("#switchModel").select2("val", "0");
                        $("#switchLocation").select2("val", "0");
                        $("#switchFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Switch added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        switchesTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add switch Function -----------------------------------------}}

        {{----------------------------------------- edit switch model ------------------------------------------------}}

        $(document).on('click', '#editSwitchLink', function (e) {
            e.preventDefault();
            let editSwitchId = $(this).data('switch_id');
            let editSwitchSerial = $(this).data('switch_serial');
            let editSwitchBrand = $(this).data('switch_brand');
            let editSwitchBrandName = $(this).data('switch_brand_name');
            let editSwitchModel = $(this).data('switch_model');
            let editSwitchModelName = $(this).data('switch_model_name');
            let editSwitchPorts = $(this).data('switch_ports');
            let editSwitchLocation = $(this).data('switch_location');
            let editSwitchFlag = $(this).data('switch_flag');
            $('#editSwitchBrandName').html(editSwitchBrandName);
            $('#editSwitchModelName').html(editSwitchModelName);
            $('#upSwitchId').val(editSwitchId);
            $('#upSwitchSerialNumber').val(editSwitchSerial);
            $('#upSwitchPorts').val(editSwitchPorts);
            $('#upSwitchBrand').val(editSwitchBrand);
            $('#upSwitchBrand').select2().trigger('change');
            $('#upSwitchModel').val(editSwitchModel);
            $('#upSwitchModel').select2().trigger('change');
            $('#upSwitchLocation').val(editSwitchLocation);
            $('#upSwitchLocation').select2().trigger('change');
            $('#upSwitchFlag').val(editSwitchFlag);
            $('#upSwitchFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit Switch model ------------------------------------------------}}

        {{----------------------------------------------- Update Switch ----------------------------------------------}}

        $(document).on('click', '#upSwitchBtn', function (e) {
            e.preventDefault();
            let upSwitchId = $('#upSwitchId').val();
            let serial_number = $('#upSwitchSerialNumber ').val();
            let upSwitchBrand = $('#upSwitchBrand').val();
            let upSwitchModel = $('#upSwitchModel').val();
            let upSwitchPorts = $('#upSwitchPorts').val();
            let upSwitchLocation = $('#upSwitchLocation').val();
            let upSwitchFlag = $('#upSwitchFlag').val();
            $.ajax({
                url: "{{ route('switches.update') }}",
                method: 'put',
                data: {
                    upSwitchId: upSwitchId,
                    serial_number: serial_number,
                    upSwitchBrand: upSwitchBrand,
                    upSwitchModel: upSwitchModel,
                    upSwitchPorts: upSwitchPorts,
                    upSwitchLocation: upSwitchLocation,
                    upSwitchFlag: upSwitchFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editSwitchModal').modal('hide');
                        $('#editSwitchForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Switch edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        switchesTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Switch --------------------------------------------}}

        {{--------------------------------------- view delete Switch model--------------------------------------------}}

        $(document).on('click','#deleteSwitchLink',function(e){
            e.preventDefault();
            let id =$(this).data('switch_id');
            $('#deleteSwitchId').val(id);
        });

        {{--------------------------------------- end view delete Switch model----------------------------------------}}

        {{------------------------------------- delete Switch function -----------------------------------------------}}

        $(document).on('click','#deleteSwitchBtn',function(e){
            e.preventDefault();
            let id=$('#deleteSwitchId').val();
            $.ajax({
                url:"{{ route('switches.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteSwitchModal').modal('hide');
                        $('#deleteSwitchForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Switch deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        switchesTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete switch function -------------------------------------------}}

        {{-------------------------------------- refresh Switches table -----------------------------------------------}}

        $(document).on('click', '#refreshSwitchesTable', function (e) {
            e.preventDefault();
            switchesTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Switches table -------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('switches.models_store') }}",
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
                        $("#switchBrand").select2("val", "0");
                        $("#switchModel").select2("val", "0");
                        $("#upSwitchBrand").select2("val", "0");
                        $("#upSwitchModel").select2("val", "0");
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

        $(document).on('change', '#switchBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('switches.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#switchModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upSwitchBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('switches.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upSwitchModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{----------------------------------------------- Switches Select2 -------------------------------------------------}}

        $('#switchBrand').select2({
            dropdownParent: $('#addSwitchModal')
        });
        $('#switchModel').select2({
            dropdownParent: $('#addSwitchModal')
        });
        $('#switchLocation').select2({
            dropdownParent: $('#addSwitchModal')
        });
        $('#switchFlag').select2({
            dropdownParent: $('#addSwitchModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upSwitchBrand').select2({
            dropdownParent: $('#editSwitchModal')
        });
        $('#upSwitchModel').select2({
            dropdownParent: $('#editSwitchModal')
        });
        $('#upSwitchLocation').select2({
            dropdownParent: $('#editSwitchModal')
        });
        $('#upSwitchFlag').select2({
            dropdownParent: $('#editSwitchModal')
        });

        {{---------------------------------------------- End Switches Select2 ----------------------------------------------}}

    });

</script>

