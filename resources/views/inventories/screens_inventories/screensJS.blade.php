<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end screens datatables function ------------------------------------------}}
        $('#screensTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var screensTable = $("#screensTable").DataTable({
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
                    title: 'Screens Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Screens Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('screens.screens')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'screen_inch', name: 't1.screen_inch'},
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

        {{--------------------------------- end screens datatables function ------------------------------------------}}

        {{---------------------------------------------- Add Screen Function -----------------------------------------}}

        $(document).on('click', '#addScreenBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#screenSerialNumber').val();
            let screenInch = $('#screenInch').val();
            let screenBrand = $('#screenBrand').val();
            let screenModel = $('#screenModel').val();
            let screenLocation = $('#screenLocation').val();
            let screenFlag = $('#screenFlag').val();
            $.ajax({
                url: "{{ route('screens.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    screenInch: screenInch,
                    screenBrand: screenBrand,
                    screenModel: screenModel,
                    screenLocation: screenLocation,
                    screenFlag: screenFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addScreenModal').modal('hide');
                        $('#addScreenForm')[0].reset();
                        $("#screenBrand").select2("val", "0");
                        $("#screenCategory").select2("val", "0");
                        $("#screenModel").select2("val", "0");
                        $("#screenLocation").select2("val", "0");
                        $("#screenFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Screen added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        screensTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add Screen Function -----------------------------------------}}

        {{----------------------------------------- edit Screen model ------------------------------------------------}}

        $(document).on('click', '#editScreenLink', function (e) {
            e.preventDefault();
            let editScreenId = $(this).data('screen_id');
            let editScreenSerial = $(this).data('screen_serial');
            let editScreenInch = $(this).data('screen_inch');
            let editScreenBrand = $(this).data('screen_brand');
            let editScreenBrandName = $(this).data('screen_brand_name');
            let editScreenModel = $(this).data('screen_model');
            let editScreenModelName = $(this).data('screen_model_name');
            let editScreenLocation = $(this).data('screen_location');
            let editScreenFlag = $(this).data('screen_flag');
            $('#editScreenBrandName').html(editScreenBrandName);
            $('#editScreenModelName').html(editScreenModelName);
            $('#upScreenId').val(editScreenId);
            $('#upScreenSerialNumber').val(editScreenSerial);
            $('#upScreenInch').val(editScreenInch);
            $('#upScreenBrand').val(editScreenBrand);
            $('#upScreenBrand').select2().trigger('change');
            $('#upScreenModel').val(editScreenModel);
            $('#upScreenModel').select2().trigger('change');
            $('#upScreenLocation').val(editScreenLocation);
            $('#upScreenLocation').select2().trigger('change');
            $('#upScreenFlag').val(editScreenFlag);
            $('#upScreenFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit Screen model ------------------------------------------------}}

        {{----------------------------------------------- Update Screen ----------------------------------------------}}

        $(document).on('click', '#upScreenBtn', function (e) {
            e.preventDefault();
            let upScreenId = $('#upScreenId').val();
            let serial_number = $('#upScreenSerialNumber ').val();
            let upScreenInch = $('#upScreenInch ').val();
            let upScreenBrand = $('#upScreenBrand').val();
            let upScreenModel = $('#upScreenModel').val();
            let upScreenLocation = $('#upScreenLocation').val();
            let upScreenFlag = $('#upScreenFlag').val();
            $.ajax({
                url: "{{ route('screens.update') }}",
                method: 'put',
                data: {
                    upScreenId: upScreenId,
                    serial_number: serial_number,
                    upScreenInch: upScreenInch,
                    upScreenBrand: upScreenBrand,
                    upScreenModel: upScreenModel,
                    upScreenLocation: upScreenLocation,
                    upScreenFlag: upScreenFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editScreenModal').modal('hide');
                        $('#editScreenForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Screen edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        screensTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Screen --------------------------------------------}}

        {{--------------------------------------- view delete screen model--------------------------------------------}}

        $(document).on('click','#deleteScreenLink',function(e){
            e.preventDefault();
            let id =$(this).data('screen_id');
            $('#deleteScreenId').val(id);
        });

        {{--------------------------------------- end view delete screen model----------------------------------------}}

        {{------------------------------------- delete screen function -----------------------------------------------}}

        $(document).on('click','#deleteScreenBtn',function(e){
            e.preventDefault();
            let id=$('#deleteScreenId').val();
            $.ajax({
                url:"{{ route('screens.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteScreenModal').modal('hide');
                        $('#deleteScreenForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Screen deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        screensTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete screen function -------------------------------------------}}

        {{-------------------------------------- refresh screens table -----------------------------------------------}}

        $(document).on('click', '#refreshScreensTable', function (e) {
            e.preventDefault();
            screensTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh screens table -------------------------------------------}}


        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('screens.models_store') }}",
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
                        $("#screenBrand").select2("val", "0");
                        $("#screenModel").select2("val", "0");
                        $("#upScreenBrand").select2("val", "0");
                        $("#upScreenModel").select2("val", "0");
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

        $(document).on('change', '#screenBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('screens.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#screenModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let screenDeliveryId = $('#screenDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('screens.delivery_to_employee')}}",
                method: "PUT",
                data: {screenDeliveryId: screenDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        screensTable.ajax.reload(null, false);
                        let url = "{{ route('screens.print_delivered', ['screenDeliveryId' => ':screenDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':screenDeliveryId', screenDeliveryId);
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

        $(document).on('change', '#upScreenBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('screens.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upScreenModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let screenDeliveryId = $(this).data('screen_id');
            $('#screenDeliveryId').val(screenDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{----------------------------------------------- Screens Select2 -------------------------------------------------}}

        $('#screenBrand').select2({
            dropdownParent: $('#addScreenModal')
        });
        $('#screenModel').select2({
            dropdownParent: $('#addScreenModal')
        });
        $('#screenLocation').select2({
            dropdownParent: $('#addScreenModal')
        });
        $('#screenFlag').select2({
            dropdownParent: $('#addScreenModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upScreenBrand').select2({
            dropdownParent: $('#editScreenModal')
        });
        $('#upScreenModel').select2({
            dropdownParent: $('#editScreenModal')
        });
        $('#upScreenLocation').select2({
            dropdownParent: $('#editScreenModal')
        });
        $('#upScreenFlag').select2({
            dropdownParent: $('#editScreenModal')
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
        {{---------------------------------------------- End Screens Select2 ----------------------------------------------}}

    });

</script>

