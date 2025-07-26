<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end Barcodes datatables function ------------------------------------------}}
        $('#barcodesTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var barcodesTable = $("#barcodesTable").DataTable({
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
                    title: 'Barcodes Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Barcodes Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('barcodes.barcodes')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
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

        {{--------------------------------- end barcodes datatables function ------------------------------------------}}

        {{---------------------------------------------- Add Barcode Function -----------------------------------------}}

        $(document).on('click', '#addBarcodeBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#barcodeSerialNumber').val();
            let barcodeBrand = $('#barcodeBrand').val();
            let barcodeModel = $('#barcodeModel').val();
            let barcodeLocation = $('#barcodeLocation').val();
            let barcodeFlag = $('#barcodeFlag').val();
            $.ajax({
                url: "{{ route('barcodes.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    barcodeBrand: barcodeBrand,
                    barcodeModel: barcodeModel,
                    barcodeLocation: barcodeLocation,
                    barcodeFlag: barcodeFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addBarcodeModal').modal('hide');
                        $('#addBarcodeForm')[0].reset();
                        $("#barcodeBrand").select2("val", "0");
                        $("#barcodeCategory").select2("val", "0");
                        $("#barcodeModel").select2("val", "0");
                        $("#barcodeLocation").select2("val", "0");
                        $("#barcodeFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Barcode added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        barcodesTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add Barcode Function -----------------------------------------}}

        {{----------------------------------------- edit Barcode model ------------------------------------------------}}

        $(document).on('click', '#editBarcodeLink', function (e) {
            e.preventDefault();
            let editBarcodeId = $(this).data('barcode_id');
            let editBarcodeSerial = $(this).data('barcode_serial');
            let editBarcodeBrand = $(this).data('barcode_brand');
            let editBarcodeBrandName = $(this).data('barcode_brand_name');
            let editBarcodeModel = $(this).data('barcode_model');
            let editBarcodeModelName = $(this).data('barcode_model_name');
            let editBarcodeLocation = $(this).data('barcode_location');
            let editBarcodeFlag = $(this).data('barcode_flag');
            $('#editBarcodeBrandName').html(editBarcodeBrandName);
            $('#editBarcodeModelName').html(editBarcodeModelName);
            $('#upBarcodeId').val(editBarcodeId);
            $('#upBarcodeSerialNumber').val(editBarcodeSerial);
            $('#upBarcodeBrand').val(editBarcodeBrand);
            $('#upBarcodeBrand').select2().trigger('change');
            $('#upBarcodeModel').val(editBarcodeModel);
            $('#upBarcodeModel').select2().trigger('change');
            $('#upBarcodeLocation').val(editBarcodeLocation);
            $('#upBarcodeLocation').select2().trigger('change');
            $('#upBarcodeFlag').val(editBarcodeFlag);
            $('#upBarcodeFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit Barcode model ------------------------------------------------}}

        {{----------------------------------------------- Update Barcode ----------------------------------------------}}

        $(document).on('click', '#upBarcodeBtn', function (e) {
            e.preventDefault();
            let upBarcodeId = $('#upBarcodeId').val();
            let serial_number = $('#upBarcodeSerialNumber ').val();
            let upBarcodeBrand = $('#upBarcodeBrand').val();
            let upBarcodeModel = $('#upBarcodeModel').val();
            let upBarcodeLocation = $('#upBarcodeLocation').val();
            let upBarcodeFlag = $('#upBarcodeFlag').val();
            $.ajax({
                url: "{{ route('barcodes.update') }}",
                method: 'put',
                data: {
                    upBarcodeId: upBarcodeId,
                    serial_number: serial_number,
                    upBarcodeBrand: upBarcodeBrand,
                    upBarcodeModel: upBarcodeModel,
                    upBarcodeLocation: upBarcodeLocation,
                    upBarcodeFlag: upBarcodeFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editBarcodeModal').modal('hide');
                        $('#editBarcodeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Barcode edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        barcodesTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Barcode --------------------------------------------}}

        {{--------------------------------------- view delete Barcode model--------------------------------------------}}

        $(document).on('click','#deleteBarcodeLink',function(e){
            e.preventDefault();
            let id =$(this).data('barcode_id');
            $('#deleteBarcodeId').val(id);
        });

        {{--------------------------------------- end view delete Barcode model----------------------------------------}}

        {{------------------------------------- delete Barcode function -----------------------------------------------}}

        $(document).on('click','#deleteBarcodeBtn',function(e){
            e.preventDefault();
            let id=$('#deleteBarcodeId').val();
            $.ajax({
                url:"{{ route('barcodes.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteBarcodeModal').modal('hide');
                        $('#deleteBarcodeForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Barcode deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        barcodesTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete Barcode function -------------------------------------------}}

        {{-------------------------------------- refresh Barcodes table -----------------------------------------------}}

        $(document).on('click', '#refreshBarcodesTable', function (e) {
            e.preventDefault();
            barcodesTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Barcodes table -------------------------------------------}}

        {{-------------------------------------- refresh Barcodes table -----------------------------------------------}}

        $(document).on('click', '#refreshDeliveredBarcodesTable', function (e) {
            e.preventDefault();
            deliveredBarcodesTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Barcodes table -------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('barcodes.models_store') }}",
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
                        $("#barcodeBrand").select2("val", "0");
                        $("#barcodeModel").select2("val", "0");
                        $("#upBarcodeBrand").select2("val", "0");
                        $("#upBarcodeModel").select2("val", "0");
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

        $(document).on('change', '#barcodeBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('barcodes.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#barcodeModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}
        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let barcodeDeliveryId = $('#barcodeDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('barcodes.delivery_to_employee')}}",
                method: "PUT",
                data: {barcodeDeliveryId: barcodeDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        barcodesTable.ajax.reload(null, false);
                        let url = "{{ route('barcodes.print_delivered', ['barcodeDeliveryId' => ':barcodeDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':barcodeDeliveryId', barcodeDeliveryId);
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

        $(document).on('change', '#upBarcodeBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('barcodes.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upBarcodeModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let barcodeDeliveryId = $(this).data('barcode_id');
            $('#barcodeDeliveryId').val(barcodeDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{----------------------------------------------- Barcodes Select2 -------------------------------------------------}}

        $('#barcodeBrand').select2({
            dropdownParent: $('#addBarcodeModal')
        });
        $('#barcodeModel').select2({
            dropdownParent: $('#addBarcodeModal')
        });
        $('#barcodeLocation').select2({
            dropdownParent: $('#addBarcodeModal')
        });
        $('#barcodeFlag').select2({
            dropdownParent: $('#addBarcodeModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });


        $('#upBarcodeBrand').select2({
            dropdownParent: $('#editBarcodeModal')
        });
        $('#upBarcodeModel').select2({
            dropdownParent: $('#editBarcodeModal')
        });
        $('#upBarcodeLocation').select2({
            dropdownParent: $('#editBarcodeModal')
        });
        $('#upBarcodeFlag').select2({
            dropdownParent: $('#editBarcodeModal')
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

        {{---------------------------------------------- End Barcodes Select2 ----------------------------------------------}}

    });

</script>

