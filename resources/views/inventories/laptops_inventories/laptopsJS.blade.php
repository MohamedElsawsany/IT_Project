<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{------------------------------------- laptops datatables function ------------------------------------------}}
        $('#LaptopsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });


        var laptops_table = $("#LaptopsTable").DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX: true,
            order: [[0, 'desc']],
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
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, ':visible']
                    },
                    title: 'Laptops Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Laptops Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('laptops.laptops')}}",
                type: "post",
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
                {data: 'screen_inch', name: 't1.screen_inch'},
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

        {{------------------------------------ End laptops datatables function ---------------------------------------}}


        {{---------------------------------------------- add Laptop function--------------------------------------------------}}

        $(document).on('click', '#addLaptopBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#LaptopSerialNumber').val();
            let LaptopBrand = $('#LaptopBrand').val();
            let LaptopModel = $('#LaptopModel').val();
            let LaptopCPU = $('#LaptopCPU').val();
            let LaptopRam = $('#LaptopRam').val();
            let LaptopGPU1 = $('#LaptopGPU1').val();
            let LaptopGPU2 = $('#LaptopGPU2').val();
            let LaptopOS = $('#LaptopOS').val();
            let LaptopFlag = $('#LaptopFlag').val();
            let LaptopHDD = $('#LaptopHDD').val();
            let LaptopSSD = $('#LaptopSSD').val();
            let LaptopLocation = $('#LaptopLocation').val();
            let LaptopScreen = $('#LaptopScreen').val();
            $.ajax({
                url: "{{ route('laptops.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    LaptopBrand: LaptopBrand,
                    LaptopModel: LaptopModel,
                    LaptopCPU: LaptopCPU,
                    LaptopRam: LaptopRam,
                    LaptopGPU1: LaptopGPU1,
                    LaptopGPU2: LaptopGPU2,
                    LaptopOS: LaptopOS,
                    LaptopFlag: LaptopFlag,
                    LaptopHDD: LaptopHDD,
                    LaptopSSD: LaptopSSD,
                    LaptopLocation: LaptopLocation,
                    LaptopScreen: LaptopScreen
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addLaptopModal').modal('hide');
                        $('#addLaptopForm')[0].reset();
                        $("#LaptopBrand").select2("val", "0");
                        $("#LaptopModel").select2("val", "0");
                        $("#LaptopCPU").select2("val", "0");
                        $("#LaptopOS").select2("val", "0");
                        $("#LaptopGPU1").select2("val", "0");
                        $("#LaptopGPU2").select2("val", "0");
                        $("#LaptopLocation").select2("val", "0");
                        $("#LaptopFlag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Laptop added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        laptops_table.ajax.reload(null, false);
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

        {{------------------------------------------- End add Laptop function -------------------------------------------------}}


        {{------------------------------------------ Edit laptop modal -----------------------------------------------}}

        $(document).on('click', '#editLaptopLink', function (e) {
            e.preventDefault();
            let up_laptop_id = $(this).data('laptop_id');
            let up_laptop_serial = $(this).data('laptop_serial');
            let up_laptop_brand = $(this).data('laptop_brand');
            let up_laptop_model = $(this).data('laptop_model');
            let up_laptop_model_name = $(this).data('laptop_model_name');
            let up_laptop_brand_name = $(this).data('laptop_brand_name');
            let up_laptop_cpu = $(this).data('laptop_cpu');
            let up_laptop_gpu1 = $(this).data('laptop_gpu1');
            let up_laptop_gpu2 = $(this).data('laptop_gpu2');
            let up_laptop_os = $(this).data('laptop_os');
            let up_laptop_screen = $(this).data('laptop_screen');
            let up_laptop_hdd = $(this).data('laptop_hdd');
            let up_laptop_ssd = $(this).data('laptop_ssd');
            let up_laptop_ram = $(this).data('laptop_ram');
            let up_laptop_location = $(this).data('laptop_location');
            let up_laptop_flag = $(this).data('laptop_flag');
            $('#editLaptopBrandName').html(up_laptop_brand_name);
            $('#editLaptopModelName').html(up_laptop_model_name);
            $('#upLaptopId').val(up_laptop_id);
            $('#upLaptopSerialNumber').val(up_laptop_serial);
            $('#upLaptopBrand').val(up_laptop_brand);
            $('#upLaptopBrand').select2().trigger('change');
            $('#upLaptopModel').val(up_laptop_model);
            $('#upLaptopModel').select2().trigger('change');
            $('#upLaptopCPU').val(up_laptop_cpu);
            $('#upLaptopCPU').select2().trigger('change');
            $('#upLaptopGPU1').val(up_laptop_gpu1);
            $('#upLaptopGPU1').select2().trigger('change');
            $('#upLaptopGPU2').val(up_laptop_gpu2);
            $('#upLaptopGPU2').select2().trigger('change');
            $('#upLaptopOS').val(up_laptop_gpu2);
            $('#upLaptopOS').select2().trigger('change');
            $('#upLaptopHDD').val(up_laptop_hdd);
            $('#upLaptopSSD').val(up_laptop_ssd);
            $('#upLaptopRam').val(up_laptop_ram);
            $('#upLaptopScreen').val(up_laptop_screen);
            $('#upLaptopLocation').val(up_laptop_location);
            $('#upLaptopLocation').select2().trigger('change');
            $('#upLaptopFlag').val(up_laptop_flag);
            $('#upLaptopFlag').select2().trigger('change');
            $('#upLaptopOS').val(up_laptop_os);
            $('#upLaptopOS').select2().trigger('change');
        });

        {{-------------------------------------- END Edit laptop modal -----------------------------------------------}}

        {{---------------------------------------------- Update Laptop function -----------------------------------------------}}

        $(document).on('click', '#upLaptopBtn', function (e) {
            e.preventDefault();
            let up_id = $('#upLaptopId').val();
            let serial_number = $('#upLaptopSerialNumber').val();
            let upLaptopBrand = $('#upLaptopBrand').val();
            let upLaptopModel = $('#upLaptopModel').val();
            let upLaptopCPU = $('#upLaptopCPU').val();
            let upLaptopRam = $('#upLaptopRam').val();
            let upLaptopGPU1 = $('#upLaptopGPU1').val();
            let upLaptopGPU2 = $('#upLaptopGPU2').val();
            let upLaptopOS = $('#upLaptopOS').val();
            let upLaptopFlag = $('#upLaptopFlag').val();
            let upLaptopHDD = $('#upLaptopHDD').val();
            let upLaptopSSD = $('#upLaptopSSD').val();
            let upLaptopScreen = $('#upLaptopScreen').val();
            let upLaptopLocation = $('#upLaptopLocation').val();
            $.ajax({
                url: "{{ route('laptops.update') }}",
                method: 'put',
                data: {
                    up_id: up_id,
                    serial_number: serial_number,
                    upLaptopBrand: upLaptopBrand,
                    upLaptopModel: upLaptopModel,
                    upLaptopCPU: upLaptopCPU,
                    upLaptopRam: upLaptopRam,
                    upLaptopGPU1: upLaptopGPU1,
                    upLaptopGPU2: upLaptopGPU2,
                    upLaptopOS: upLaptopOS,
                    upLaptopFlag: upLaptopFlag,
                    upLaptopHDD: upLaptopHDD,
                    upLaptopSSD: upLaptopSSD,
                    upLaptopScreen: upLaptopScreen,
                    upLaptopLocation: upLaptopLocation
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editLaptopModal').modal('hide');
                        $('#editLaptopForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Laptop edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        laptops_table.ajax.reload(null, false);
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

        {{------------------------------------------- End Update Laptop function ----------------------------------------------}}

        {{---------------------------------------- view delete laptop modal ------------------------------------------}}

        $(document).on('click', '#deleteLaptopLink', function (e) {
            e.preventDefault();
            let id = $(this).data('laptop_id');
            $('#deleteLaptopId').val(id);
        });

        {{---------------------------------------- end view delete laptop modal --------------------------------------}}

        {{----------------------------------------- delete Laptop ----------------------------------------------------}}

        $(document).on('click', '#deleteLaptopBtn', function (e) {
            e.preventDefault();
            let id = $('#deleteLaptopId').val();
            $.ajax({
                url: "{{ route('laptops.soft_delete') }}",
                method: 'delete',
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deleteLaptopModal').modal('hide');
                        $('#deleteLaptopForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Laptop deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        laptops_table.ajax.reload(null, false);
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

        {{----------------------------------------- end delete Laptop ------------------------------------------------}}

        {{---------------------------------------- refresh laptops table ---------------------------------------------}}

        $(document).on('click', '#refreshLaptopsTable', function (e) {
            e.preventDefault();
            laptops_table.ajax.reload(null, false);
        });

        {{---------------------------------------- end refresh laptops table -----------------------------------------}}
        {{-- Add Employee Function--}}
        $(document).on('click', '#addEmployeeBtn', function (e) {
            e.preventDefault();
            let employee_name = $('#employee_name').val();
            let departmentName = $('#departmentName').val();
            $.ajax({
                url: "{{ route('employees.store') }}",
                method: "POST",
                data: {employee_name: employee_name, departmentName: departmentName},
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
        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('laptops.models_store') }}",
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
                        $("#LaptopBrand").select2("val", "0");
                        $("#LaptopModel").select2("val", "0");
                        $("#upLaptopBrand").select2("val", "0");
                        $("#upLaptopModel").select2("val", "0");
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

        {{------------------------------------------- Add Develiry Function ---------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeBtn', function (e) {
            e.preventDefault();
            let laptopDeliveryId = $('#laptopDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('laptops.delivery_to_employee')}}",
                method: "PUT",
                data: {laptopDeliveryId: laptopDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        laptops_table.ajax.reload(null, false);
                        let url = "{{ route('laptops.print_delivered', ['laptopDeliveryId' => ':laptopDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':laptopDeliveryId', laptopDeliveryId);
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

        {{------------------------------------------- Dependent Model while adding------------------------------------}}

        $(document).on('change', '#LaptopBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('laptops.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#LaptopModel").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding--------------------------------}}

        {{------------------------------------------- Dependent Model while editing-----------------------------------}}

        $(document).on('change', '#upLaptopBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            $.ajax({
                url: "{{ route('laptops.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#upLaptopModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-------------------------------}}

        {{---------------------------------------------- Delivery Laptop-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let laptopDeliveryId = $(this).data('laptop_id');
            $('#laptopDeliveryId').val(laptopDeliveryId);
        });

        {{------------------------------------------ Delivery Laptop -----------------------------------------------}}
        {{------------------------------------------------ Laptop Select2 --------------------------------------------}}

        $('#LaptopBrand').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopModel').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopCPU').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopGPU1').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopGPU2').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopLocation').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopOS').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#LaptopFlag').select2({
            dropdownParent: $('#addLaptopModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });
        $('#employeeNumberDelivery').select2({
            dropdownParent: $('#deliveryToEmployeeModal')
        });

        $('#UpLaptopBrand').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopModel').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopCpu').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopGpu1').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopGpu2').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopLocation').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopOS').select2({
            dropdownParent: $('#editLaptopModal')
        });
        $('#UpLaptopFlag').select2({
            dropdownParent: $('#editLaptopModal')
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

        {{--------------------------------------------- End Laptop Select2 -------------------------------------------}}

    });

</script>

