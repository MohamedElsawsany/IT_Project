<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{------------------------------------------ PCs datatables function  ----------------------------------------}}
        $('#PCsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var PC_table = $("#PCsTable").DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX: true,
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
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, ':visible']
                    },
                    title: 'PCs Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'PCs Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('pcs.pcs')}}",
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

        {{-------------------------------------- end PCs datatables function  ----------------------------------------}}

        {{---------------------------------------------- Add PC ------------------------------------------------------}}

        $(document).on('click', '#addPCBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#PCserialNumber').val();
            let PC_brand = $('#PC_brand').val();
            let PC_model = $('#PC_model').val();
            let PC_CPU = $('#PC_CPU').val();
            let PC_ram = $('#PC_ram').val();
            let PC_GPU1 = $('#PC_GPU1').val();
            let PC_GPU2 = $('#PC_GPU2').val();
            let PC_OS = $('#PC_OS').val();
            let PC_flag = $('#PC_flag').val();
            let PC_HDD = $('#PC_HDD_Storage').val();
            let PC_SSD = $('#PC_SSD_Storage').val();
            let PC_location = $('#PC_location').val();
            $.ajax({
                url: "{{ route('pcs.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    PC_brand: PC_brand,
                    PC_model: PC_model,
                    PC_CPU: PC_CPU,
                    PC_GPU1: PC_GPU1,
                    PC_GPU2: PC_GPU2,
                    PC_HDD: PC_HDD,
                    PC_SSD: PC_SSD,
                    PC_location: PC_location,
                    PC_ram: PC_ram,
                    PC_flag: PC_flag,
                    PC_OS: PC_OS
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addPCModal').modal('hide');
                        $('#addPCForm')[0].reset();
                        $("#PC_brand").select2("val", "0");
                        $("#PC_model").select2("val", "0");
                        $("#PC_OS").select2("val", "0");
                        $("#PC_CPU").select2("val", "0");
                        $("#PC_GPU1").select2("val", "0");
                        $("#PC_GPU2").select2("val", "0");
                        $("#PC_location").select2("val", "0");
                        $("#PC_flag").select2("val", "0");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'PC added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        PC_table.ajax.reload(null, false);
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

        {{---------------------------------------------- End Add PC --------------------------------------------------}}

        {{---------------------------------------------- Edit PC modal -----------------------------------------------}}

        $(document).on('click', '#editPCLink', function (e) {
            e.preventDefault();
            let up_pc_id = $(this).data('pc_id');
            let up_pc_serial = $(this).data('pc_serial');
            let up_pc_brand = $(this).data('pc_brand');
            let up_pc_model = $(this).data('pc_model');
            let up_pc_model_name = $(this).data('pc_model_name');
            let up_pc_brand_name = $(this).data('pc_brand_name');
            let up_pc_cpu = $(this).data('pc_cpu');
            let up_pc_gpu1 = $(this).data('pc_gpu1');
            let up_pc_gpu2 = $(this).data('pc_gpu2');
            let up_pc_os = $(this).data('pc_os');
            let up_pc_hdd = $(this).data('pc_hdd');
            let up_pc_ssd = $(this).data('pc_ssd');
            let up_pc_ram = $(this).data('pc_ram');
            let up_pc_location = $(this).data('pc_location');
            let up_pc_falg = $(this).data('pc_flag');
            $('#editPCBrandName').html(up_pc_brand_name);
            $('#editPCModelName').html(up_pc_model_name);
            $('#UpPcId').val(up_pc_id);
            $('#UpPcSerialNumber').val(up_pc_serial);
            $('#UpPcBrand').val(up_pc_brand);
            $('#UpPcBrand').select2().trigger('change');
            $('#UpPcModel').val(up_pc_model);
            $('#UpPcModel').select2().trigger('change');
            $('#UpPcCpu').val(up_pc_cpu);
            $('#UpPcCpu').select2().trigger('change');
            $('#UpPcGpu1').val(up_pc_gpu1);
            $('#UpPcGpu1').select2().trigger('change');
            $('#UpPcGpu2').val(up_pc_gpu2);
            $('#UpPcGpu2').select2().trigger('change');
            $('#UpPcHdd').val(up_pc_hdd);
            $('#UpPcSsd').val(up_pc_ssd);
            $('#UpPcRam').val(up_pc_ram);
            $('#UpPcLocation').val(up_pc_location);
            $('#UpPcLocation').select2().trigger('change');
            $('#UpPcOS').val(up_pc_os);
            $('#UpPcOS').select2().trigger('change');
            $('#UpPcFlag').val(up_pc_falg);
            $('#UpPcFlag').select2().trigger('change');
            $('#hiddenModelValue').val(up_pc_model);

        });

        {{------------------------------------------ END Edit PC modal -----------------------------------------------}}

        {{----------------------------------------------- Update PC --------------------------------------------------}}

        $(document).on('click', '#upPcBtn', function (e) {
            e.preventDefault();
            let up_id = $('#UpPcId').val();
            let serial_number = $('#UpPcSerialNumber').val();
            let pc_brand = $('#UpPcBrand').val();
            let pc_model = $('#UpPcModel').val();
            let pc_cpu = $('#UpPcCpu').val();
            let pc_ram = $('#UpPcRam').val();
            let pc_gpu1 = $('#UpPcGpu1').val();
            let pc_gpu2 = $('#UpPcGpu2').val();
            let pc_os = $('#UpPcOS').val();
            let pc_flag = $('#UpPcFlag').val();
            let pc_hdd = $('#UpPcHdd').val();
            let pc_ssd = $('#UpPcSsd').val();
            let pc_location = $('#UpPcLocation').val();
            $.ajax({
                url: "{{ route('pcs.update') }}",
                method: 'put',
                data: {
                    up_id: up_id,
                    serial_number: serial_number,
                    pc_brand: pc_brand,
                    pc_model: pc_model,
                    pc_cpu: pc_cpu,
                    pc_ram: pc_ram,
                    pc_gpu1: pc_gpu1,
                    pc_gpu2: pc_gpu2,
                    pc_flag: pc_flag,
                    pc_hdd: pc_hdd,
                    pc_ssd: pc_ssd,
                    pc_os: pc_os,
                    pc_location: pc_location
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editPCModal').modal('hide');
                        $('#editPCForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'PC edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        PC_table.ajax.reload(null, false);
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

        {{------------------------------------------- End Update PC --------------------------------------------------}}

        {{----------------------------------------- view delete PC Modal ---------------------------------------------}}

        $(document).on('click', '#deletePCLink', function (e) {
            e.preventDefault();
            let id = $(this).data('pc_id');
            $('#deletePCId').val(id);
        });

        {{----------------------------------------- end view delete PC Modal -----------------------------------------}}

        {{--------------------------------------------- delete PC ----------------------------------------------------}}

        $(document).on('click', '#deletePCBtn', function (e) {
            e.preventDefault();
            let id = $('#deletePCId').val();
            $.ajax({
                url: "{{ route('pcs.soft_delete') }}",
                method: 'delete',
                data: {id: id},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#deletePCModal').modal('hide');
                        $('#deletePCForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'PC deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        PC_table.ajax.reload(null, false);
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

        {{----------------------------------------- end delete PC ----------------------------------------------------}}

        {{----------------------------------------- refresh PCs table ------------------------------------------------}}

        $(document).on('click', '#refreshPCsTable', function (e) {
            e.preventDefault();
            PC_table.ajax.reload(null, false);
        });



        {{----------------------------------------- end refresh PCs table --------------------------------------------}}

        {{------------------------------------------- Add Model Function ---------------------------------------------}}

        $(document).on('click', '#addModelBtn', function (e) {
            e.preventDefault();
            let model_name = $('#modelName').val();
            let brand_id = $('#modelBrand').val();
            $.ajax({
                url: "{{ route('pcs.models_store') }}",
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
                        $("#PC_brand").select2("val", "0");
                        $("#PC_model").select2("val", "0");
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
            let PCDeliveryId = $('#PCDeliveryId').val();
            let employeeNumberDelivery = $('#employeeNumberDelivery').val();
            $.ajax({
                url: "{{route('pcs.delivery_to_employee')}}",
                method: "PUT",
                data: {PCDeliveryId: PCDeliveryId, employeeNumberDelivery: employeeNumberDelivery},
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
                        PC_table.ajax.reload(null, false);
                        let url = "{{ route('pcs.print_delivered', ['PCDeliveryId' => ':PCDeliveryId', 'employeeNumberDelivery' => ':employeeNumberDelivery']) }}";
                        url = url.replace(':PCDeliveryId', PCDeliveryId);
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

        {{------------------------------------------- Dependent Model while adding-----------------------------------------}}

        $(document).on('change', '#PC_brand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            ;
            $.ajax({
                url: "{{ route('pcs.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#PC_model").html(data);
                }
            });
        });

        {{------------------------------------------- End Dependent Model while adding-----------------------------------------}}
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
        {{------------------------------------------- Dependent Model while editing-----------------------------------------}}

        $(document).on('change', '#UpPcBrand', function (e) {
            e.preventDefault();
            let brand_id = $(this).val();
            let modelValue = $('#hiddenModelValue').val();
            $.ajax({
                url: "{{ route('pcs.get_models') }}",
                type: 'POST',
                data: {
                    brand_id: brand_id
                },
                success: function (data) {
                    $("#UpPcModel").html(data);
                }
            });

        });

        {{------------------------------------------- End Dependent Model while editing-----------------------------------------}}

        {{---------------------------------------------- Delivery PC-----------------------------------------------}}

        $(document).on('click', '#deliveryToEmployeeLink', function (e) {
            e.preventDefault();
            let pcDeliveryId = $(this).data('pc_id');
            $('#PCDeliveryId').val(pcDeliveryId);
        });

        {{------------------------------------------ END Delivery PC -----------------------------------------------}}

        {{------------------------------------------- PC Select2 -----------------------------------------------------}}

        $('#PC_brand').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_model').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_CPU').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_GPU1').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_GPU2').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_location').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_OS').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#PC_flag').select2({
            dropdownParent: $('#addPCModal')
        });
        $('#modelBrand').select2({
            dropdownParent: $('#addModelModal')
        });

        $('#UpPcBrand').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcModel').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcCpu').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcGpu1').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcGpu2').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcLocation').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcOS').select2({
            dropdownParent: $('#editPCModal')
        });
        $('#UpPcFlag').select2({
            dropdownParent: $('#editPCModal')
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

    });

</script>

