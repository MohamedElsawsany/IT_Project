<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end Modems datatables function ------------------------------------------}}
        $('#modemsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });
        var modemsTable = $("#modemsTable").DataTable({
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
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    },
                    title: 'Modems Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Modems Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('modems.modems')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'brand_name', name: 't2.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'type_name', name: 't11.type_name'},
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

        {{--------------------------------- end Modems datatables function ------------------------------------------}}


        {{---------------------------------------------- Add Modem Function -----------------------------------------}}

        $(document).on('click', '#addModemBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#modemSerialNumber').val();
            let modemBrand = $('#modemBrand').val();
            let modemModel = $('#modemModel').val();
            let modemType = $('#modemType').val();
            let modemLocation = $('#modemLocation').val();
            let modemFlag = $('#modemFlag').val();
            $.ajax({
                url: "{{ route('modems.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    modemBrand: modemBrand,
                    modemModel: modemModel,
                    modemType: modemType,
                    modemLocation: modemLocation,
                    modemFlag: modemFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addModemModal').modal('hide');
                        $('#addModemForm')[0].reset();
                        $("#modemBrand").select2("val", "0");
                        $("#modemCategory").select2("val", "0");
                        $("#modemModel").select2("val", "0");
                        $("#modemType").select2("val", "0");
                        $("#modemLocation").select2("val", "0");
                        $("#modemFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Modem added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        modemsTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add Modem Function -----------------------------------------}}

        {{----------------------------------------- edit Modem model ------------------------------------------------}}

        $(document).on('click', '#editModemLink', function (e) {
            e.preventDefault();
            let editModemId = $(this).data('modem_id');
            let editModemSerial = $(this).data('modem_serial');
            let editModemBrand = $(this).data('modem_brand');
            let editModemBrandName = $(this).data('modem_brand_name');
            let editModemModel = $(this).data('modem_model');
            let editModemModelName = $(this).data('modem_model_name');
            let editModemType = $(this).data('modem_type');
            let editModemLocation = $(this).data('modem_location');
            let editModemFlag = $(this).data('modem_flag');
            $('#editModemBrandName').html(editModemBrandName);
            $('#editModemModelName').html(editModemModelName);
            $('#upModemId').val(editModemId);
            $('#upModemSerialNumber').val(editModemSerial);
            $('#upModemType').val(editModemType);
            $('#upModemType').select2().trigger('change');
            $('#upModemBrand').val(editModemBrand);
            $('#upModemBrand').select2().trigger('change');
            $('#upModemModel').val(editModemModel);
            $('#upModemModel').select2().trigger('change');
            $('#upModemLocation').val(editModemLocation);
            $('#upModemLocation').select2().trigger('change');
            $('#upModemFlag').val(editModemFlag);
            $('#upModemFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit Modem model ------------------------------------------------}}

        {{----------------------------------------------- Update Modem ----------------------------------------------}}

        $(document).on('click', '#upModemBtn', function (e) {
            e.preventDefault();
            let upModemId = $('#upModemId').val();
            let serial_number = $('#upModemSerialNumber ').val();
            let upModemBrand = $('#upModemBrand').val();
            let upModemModel = $('#upModemModel').val();
            let upModemType = $('#upModemType').val();
            let upModemLocation = $('#upModemLocation').val();
            let upModemFlag = $('#upModemFlag').val();
            $.ajax({
                url: "{{ route('modems.update') }}",
                method: 'put',
                data: {
                    upModemId: upModemId,
                    serial_number: serial_number,
                    upModemBrand: upModemBrand,
                    upModemModel: upModemModel,
                    upModemType: upModemType,
                    upModemLocation: upModemLocation,
                    upModemFlag: upModemFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editModemModal').modal('hide');
                        $('#editModemForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Modem edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        modemsTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Modem --------------------------------------------}}

        {{--------------------------------------- view delete Modem model--------------------------------------------}}

        $(document).on('click','#deleteModemLink',function(e){
            e.preventDefault();
            let id =$(this).data('modem_id');
            $('#deleteModemId').val(id);
        });

        {{--------------------------------------- end view delete Modem model----------------------------------------}}

        {{------------------------------------- delete Modem function -----------------------------------------------}}

        $(document).on('click','#deleteModemBtn',function(e){
            e.preventDefault();
            let id=$('#deleteModemId').val();
            $.ajax({
                url:"{{ route('modems.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteModemModal').modal('hide');
                        $('#deleteModemForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Modem deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        modemsTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete Modem function -------------------------------------------}}

        {{-------------------------------------- refresh Modems table -----------------------------------------------}}

        $(document).on('click', '#refreshModemsTable', function (e) {
            e.preventDefault();
            modemsTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Modems table -------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('modems.models_store') }}",
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
                        $("#modemBrand").select2("val", "0");
                        $("#modemModel").select2("val", "0");
                        $("#upModemBrand").select2("val", "0");
                        $("#upModemModel").select2("val", "0");
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

        $(document).on('change', '#modemBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('modems.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#modemModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let modemDeliveryId = $('#modemDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('modems.delivery_to_employee')}}",
                method: "PUT",
                data: {modemDeliveryId: modemDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deliveryToEmployeeModal').modal('hide');
                        $('#deliveryToEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Delivered successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        modemsTable.ajax.reload(null, false);
                        let url = "{{ route('modems.print_delivered', ['modemDeliveryId' => ':modemDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':modemDeliveryId', modemDeliveryId);
                        url = url.replace(':employeeNumberDelivery', employeeNumberDelivery);
                        window.location.href = url;
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

        {{------------------------------------------- End Add Develiry Function -----------------------------------------}}
        {{-- Add Employee Function--}}
        $(document).on('click', '#addEmployeeBtn', function (e) {
            e.preventDefault();
            let employee_name = $('#employee_name').val();
            let departmentName = $('#departmentName').val();
            $.ajax({
                url: "{{ route('employees.store') }}",
                method: "POST",
                data: {employee_name: employee_name,departmentName:departmentName},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addEmployeeModal').modal('hide');
                        $('#addEmployeeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Employee added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#departmentName").select2("val", "0");
                        table.ajax.reload(null, false);
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

        {{--    End Add Employee Function   --}}
        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upModemBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('modems.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upModemModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let modemDeliveryId = $(this).data('modem_id');
            $('#modemDeliveryId').val(modemDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{----------------------------------------------- Modems Select2 -------------------------------------------------}}

        $('#modemBrand').select2({
            dropdownParent: $('#addModemModal')
        });
        $('#modemModel').select2({
            dropdownParent: $('#addModemModal')
        });
        $('#modemType').select2({
            dropdownParent: $('#addModemModal')
        });
        $('#modemLocation').select2({
            dropdownParent: $('#addModemModal')
        });
        $('#modemFlag').select2({
            dropdownParent: $('#addModemModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upModemBrand').select2({
            dropdownParent: $('#editModemModal')
        });
        $('#upModemModel').select2({
            dropdownParent: $('#editModemModal')
        });
        $('#upModemType').select2({
            dropdownParent: $('#editModemModal')
        });
        $('#upModemLocation').select2({
            dropdownParent: $('#editModemModal')
        });
        $('#upModemFlag').select2({
            dropdownParent: $('#editModemModal')
        });

        $('#departmentName').select2({
            dropdownParent: $('#addEmployeeModal')
        });

        $("#employeeNumberDelivery").select2({
            placeholder: 'Select Employee...',
            // width: '350px',
            allowClear: true,
            ajax: {
                url: '{{route('employees.get_all_employees_json')}}',
                method: "post",
                dataType: 'json',
                delay: 1000,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
        });

        {{---------------------------------------------- End Modems Select2 ----------------------------------------------}}

    });

</script>

