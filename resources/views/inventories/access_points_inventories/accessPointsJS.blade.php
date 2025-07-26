<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end Routers datatables function ------------------------------------------}}
        $('#accessPointsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var accessPointsTable = $("#accessPointsTable").DataTable({
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
                    title: 'Access Points Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Access Points Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('access_points.access_points')}}",
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

        {{--------------------------------- end Access Points datatables function ------------------------------------------}}

        {{---------------------------------------------- Add Access Point Function -----------------------------------------}}

        $(document).on('click', '#addAccessPointBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#accessPointSerialNumber').val();
            let accessPointBrand = $('#accessPointBrand').val();
            let accessPointModel = $('#accessPointModel').val();
            let accessPointLocation = $('#accessPointLocation').val();
            let accessPointFlag = $('#accessPointFlag').val();
            $.ajax({
                url: "{{ route('access_points.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    accessPointBrand: accessPointBrand,
                    accessPointModel: accessPointModel,
                    accessPointLocation: accessPointLocation,
                    accessPointFlag: accessPointFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addAccessPointModal').modal('hide');
                        $('#addAccessPointForm')[0].reset();
                        $("#accessPointBrand").select2("val", "0");
                        $("#accessPointCategory").select2("val", "0");
                        $("#accessPointModel").select2("val", "0");
                        $("#accessPointLocation").select2("val", "0");
                        $("#accessPointFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Access Point added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        accessPointsTable.ajax.reload(null, false);
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

        {{------------------------------------------ End Add Access Point Function -----------------------------------------}}

        {{----------------------------------------- edit Access Point model ------------------------------------------------}}

        $(document).on('click', '#editAccessPointLink', function (e) {
            e.preventDefault();
            let editAccessPointId = $(this).data('access_point_id');
            let editAccessPointSerial = $(this).data('access_point_serial');
            let editAccessPointBrand = $(this).data('access_point_brand');
            let editAccessPointBrandName = $(this).data('access_point_brand_name');
            let editAccessPointModel = $(this).data('access_point_model');
            let editAccessPointModelName = $(this).data('access_point_model_name');
            let editAccessPointLocation = $(this).data('access_point_location');
            let editAccessPointFlag = $(this).data('access_point_flag');
            $('#editAccessPointBrandName').html(editAccessPointBrandName);
            $('#editAccessPointModelName').html(editAccessPointModelName);
            $('#upAccessPointId').val(editAccessPointId);
            $('#upAccessPointSerialNumber').val(editAccessPointSerial);
            $('#upAccessPointBrand').val(editAccessPointBrand);
            $('#upAccessPointBrand').select2().trigger('change');
            $('#upAccessPointModel').val(editAccessPointModel);
            $('#upAccessPointModel').select2().trigger('change');
            $('#upAccessPointLocation').val(editAccessPointLocation);
            $('#upAccessPointLocation').select2().trigger('change');
            $('#upAccessPointFlag').val(editAccessPointFlag);
            $('#upAccessPointFlag').select2().trigger('change');
        });

        {{------------------------------------- END edit Access Point model ------------------------------------------------}}

        {{----------------------------------------------- Update Access Point ----------------------------------------------}}

        $(document).on('click', '#upAccessPointBtn', function (e) {
            e.preventDefault();
            let upAccessPointId = $('#upAccessPointId').val();
            let serial_number = $('#upAccessPointSerialNumber ').val();
            let upAccessPointBrand = $('#upAccessPointBrand').val();
            let upAccessPointModel = $('#upAccessPointModel').val();
            let upAccessPointLocation = $('#upAccessPointLocation').val();
            let upAccessPointFlag = $('#upAccessPointFlag').val();
            $.ajax({
                url: "{{ route('access_points.update') }}",
                method: 'put',
                data: {
                    upAccessPointId: upAccessPointId,
                    serial_number: serial_number,
                    upAccessPointBrand: upAccessPointBrand,
                    upAccessPointModel: upAccessPointModel,
                    upAccessPointLocation: upAccessPointLocation,
                    upAccessPointFlag: upAccessPointFlag
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editAccessPointModal').modal('hide');
                        $('#editAccessPointForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Access Point edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        accessPointsTable.ajax.reload(null, false);
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

        {{--------------------------------------------- End Update Access Point --------------------------------------------}}

        {{--------------------------------------- view delete Access Point modal--------------------------------------------}}

        $(document).on('click','#deleteAccessPointLink',function(e){
            e.preventDefault();
            let id =$(this).data('access_point_id');
            $('#deleteAccessPointId').val(id);
        });

        {{--------------------------------------- end view delete Access Point modal----------------------------------------}}

        {{------------------------------------- delete Access Point function -----------------------------------------------}}

        $(document).on('click','#deleteAccessPointBtn',function(e){
            e.preventDefault();
            let id=$('#deleteAccessPointId').val();
            $.ajax({
                url:"{{ route('access_points.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteAccessPointModal').modal('hide');
                        $('#deleteAccessPointForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Access Point deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        accessPointsTable.ajax.reload( null, false );
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

        {{------------------------------------- end delete AccessPoint function -------------------------------------------}}

        {{-------------------------------------- refresh Access Points table -----------------------------------------------}}

        $(document).on('click', '#refreshAccessPointsTable', function (e) {
            e.preventDefault();
            accessPointsTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Access Points table -------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('access_points.models_store') }}",
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
                        $("#accessPointBrand").select2("val", "0");
                        $("#accessPointModel").select2("val", "0");
                        $("#upAccessPointBrand").select2("val", "0");
                        $("#upAccessPointModel").select2("val", "0");
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

        $(document).on('change', '#accessPointBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('access_points.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#accessPointModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let accessPointDeliveryId = $('#accessPointDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('access_points.delivery_to_employee')}}",
                method: "PUT",
                data: {accessPointDeliveryId: accessPointDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        accessPointsTable.ajax.reload(null, false);
                        let url = "{{ route('access_points.print_delivered', ['accessPointDeliveryId' => ':accessPointDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':accessPointDeliveryId', accessPointDeliveryId);
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

        $(document).on('change', '#upAccessPointBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('access_points.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upAccessPointModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let accessPointDeliveryId = $(this).data('access_point_id');
            $('#accessPointDeliveryId').val(accessPointDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{----------------------------------------------- Access Points Select2 -------------------------------------------------}}

        $('#accessPointBrand').select2({
            dropdownParent: $('#addAccessPointModal')
        });
        $('#accessPointModel').select2({
            dropdownParent: $('#addAccessPointModal')
        });
        $('#accessPointLocation').select2({
            dropdownParent: $('#addAccessPointModal')
        });
        $('#accessPointFlag').select2({
            dropdownParent: $('#addAccessPointModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#upAccessPointBrand').select2({
            dropdownParent: $('#editAccessPointModal')
        });
        $('#upAccessPointModel').select2({
            dropdownParent: $('#editAccessPointModal')
        });
        $('#upAccessPointLocation').select2({
            dropdownParent: $('#editAccessPointModal')
        });
        $('#upAccessPointFlag').select2({
            dropdownParent: $('#editAccessPointModal')
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

        {{---------------------------------------------- End Access Points Select2 ----------------------------------------------}}

    });

</script>
