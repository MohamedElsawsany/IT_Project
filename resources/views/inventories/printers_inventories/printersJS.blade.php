<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{------------------------------------- printers datatables function -----------------------------------------}}
        $('#printersTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });
        var printersTable = $("#printersTable").DataTable({
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
                    title: 'Printers & Scanners Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Printers & Scanners Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('printers.printers')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'category_name', name: 't4.category_name'},
                {data: 'brand_name', name: 't2.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
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

        {{--------------------------------------- end printers datatables function -----------------------------------}}


        {{------------------------------------------- Add Printer Function -------------------------------------------}}

        $(document).on('click', '#addPrinterBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#printerSerialNumber').val();
            let printerCategory = $('#printerCategory').val();
            let printerBrand = $('#printerBrand').val();
            let printerModel = $('#printerModel').val();
            let printerLocation = $('#printerLocation').val();
            let printerFlag = $('#printerFlag').val();
            $.ajax({
                url: "{{ route('printers.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    printerCategory: printerCategory,
                    printerBrand: printerBrand,
                    printerModel: printerModel,
                    printerLocation: printerLocation,
                    printerFlag: printerFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addPrinterModal').modal('hide');
                        $('#addPrinterForm')[0].reset();
                        $("#printerBrand").select2("val", "0");
                        $("#printerCategory").select2("val", "0");
                        $("#printerModel").select2("val", "0");
                        $("#printerLocation").select2("val", "0");
                        $("#printerFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Printer added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        printersTable.ajax.reload(null, false);
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

        {{-------------------------------------------- End Add Printer Function --------------------------------------}}


        {{--------------------------------------------- edit printer modal -------------------------------------------}}

        $(document).on('click', '#editPrinterLink', function (e) {
            e.preventDefault();
            let editPrinterId = $(this).data('printer_id');
            let editPrinterSerial = $(this).data('printer_serial');
            let editPrinterCategory = $(this).data('printer_category');
            let editPrinterBrand = $(this).data('printer_brand');
            let editPrinterBrandName = $(this).data('printer_brand_name');
            let editPrinterModel = $(this).data('printer_model');
            let editPrinterModelName = $(this).data('printer_model_name');
            let editPrinterLocation = $(this).data('printer_location');
            let editPrinterFlag = $(this).data('printer_flag');
            $('#editPrinterBrandName').html(editPrinterBrandName);
            $('#editPrinterModelName').html(editPrinterModelName);
            $('#upPrinterId').val(editPrinterId);
            $('#upPrinterSerialNumber').val(editPrinterSerial);
            $('#upPrinterCategory').val(editPrinterCategory);
            $('#upPrinterCategory').select2().trigger('change');
            $('#upPrinterBrand').val(editPrinterBrand);
            $('#upPrinterBrand').select2().trigger('change');
            $('#upPrinterModel').val(editPrinterModel);
            $('#upPrinterModel').select2().trigger('change');
            $('#upPrinterLocation').val(editPrinterLocation);
            $('#upPrinterLocation').select2().trigger('change');
            $('#upPrinterFlag').val(editPrinterFlag);
            $('#upPrinterFlag').select2().trigger('change');
        });

        {{------------------------------------------- end edit printer modal -----------------------------------------}}

        {{------------------------------------------------ Update Printer function --------------------------------------------}}

        $(document).on('click', '#upPrinterBtn', function (e) {
            e.preventDefault();
            let upPrinterId = $('#upPrinterId').val();
            let serial_number = $('#upPrinterSerialNumber ').val();
            let upPrinterCategory = $('#upPrinterCategory ').val();
            let upPrinterBrand = $('#upPrinterBrand').val();
            let upPrinterModel = $('#upPrinterModel').val();
            let upPrinterLocation = $('#upPrinterLocation').val();
            let upPrinterFlag = $('#upPrinterFlag').val();
            $.ajax({
                url: "{{ route('printers.update') }}",
                method: 'put',
                data: {
                    upPrinterId: upPrinterId,
                    serial_number: serial_number,
                    upPrinterCategory: upPrinterCategory,
                    upPrinterBrand: upPrinterBrand,
                    upPrinterModel: upPrinterModel,
                    upPrinterLocation: upPrinterLocation,
                    upPrinterFlag: upPrinterFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editPrinterModal').modal('hide');
                        $('#editPrinterForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Printer edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        printersTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Printer function -------------------------------------------}}

        {{----------------------------------------- view delete printer model ----------------------------------------}}

        $(document).on('click', '#deletePrinterLink', function (e) {
            e.preventDefault();
            let id = $(this).data('printer_id');
            $('#deletePrinterId').val(id);
        });

        {{---------------------------------------- end view delete printer model -------------------------------------}}

        {{----------------------------------------------- delete Printer  --------------------------------------------}}

        $(document).on('click', '#deletePrinterBtn', function (e) {
            e.preventDefault();
            let id = $('#deletePrinterId').val();
            $.ajax({
                url: "{{ route('printers.soft_delete') }}",
                method: 'delete',
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deletePrinterModal').modal('hide');
                        $('#deletePrinterForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Printer deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        printersTable.ajax.reload(null, false);
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

        {{------------------------------------------- end delete printer ---------------------------------------------}}

        {{------------------------------------------ refresh printers table ------------------------------------------}}

        $(document).on('click', '#refreshPrintersTable', function (e) {
            e.preventDefault();
            printersTable.ajax.reload(null, false);
        });

        {{----------------------------------------- end refresh printers table ---------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('printers.models_store') }}",
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
                        $("#printerBrand").select2("val", "0");
                        $("#printerModel").select2("val", "0");
                        $("#upPrinterBrand").select2("val", "0");
                        $("#upPrinterModel").select2("val", "0");
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
        {{------------------------------------------- Dependent Model while adding------------------------------------}}

        $(document).on('change', '#printerBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('printers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#printerModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let printerDeliveryId = $('#printerDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('printers.delivery_to_employee')}}",
                method: "PUT",
                data: {printerDeliveryId: printerDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        printersTable.ajax.reload(null, false);
                        let url = "{{ route('printers.print_delivered', ['printerDeliveryId' => ':printerDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':printerDeliveryId', printerDeliveryId);
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

        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upPrinterBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('printers.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upPrinterModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let printerDeliveryId = $(this).data('printer_id');
            $('#printerDeliveryId').val(printerDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{--------------------------------------------- Printer Select2 ----------------------------------------------}}

        $('#printerCategory').select2({
            dropdownParent: $('#addPrinterModal')
        });
        $('#printerBrand').select2({
            dropdownParent: $('#addPrinterModal')
        });
        $('#printerModel').select2({
            dropdownParent: $('#addPrinterModal')
        });
        $('#printerLocation').select2({
            dropdownParent: $('#addPrinterModal')
        });
        $('#printerFlag').select2({
            dropdownParent: $('#addPrinterModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upPrinterCategory').select2({
            dropdownParent: $('#editPrinterModal')
        });
        $('#upPrinterBrand').select2({
            dropdownParent: $('#editPrinterModal')
        });
        $('#upPrinterModel').select2({
            dropdownParent: $('#editPrinterModal')
        });
        $('#upPrinterLocation').select2({
            dropdownParent: $('#editPrinterModal')
        });
        $('#upPrinterFlag').select2({
            dropdownParent: $('#editPrinterModal')
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

        {{--------------------------------------------- End Printer Select2 ------------------------------------------}}

    });

</script>

