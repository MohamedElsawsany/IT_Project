<script>
    $(document).ready(function () {
        {{------------------------------------------ Add Brand Function ----------------------------------------------}}

        $(document).on('click', '#addBrandBtn', function (e) {
            e.preventDefault();
            let brand_name = $('#brandName').val();
            $.ajax({
                url: "{{ route('brands.store') }}",
                method: "POST",
                data: {brand_name: brand_name},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addBrandModal').modal('hide');
                        $('#addBrandForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Brand added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $.ajax({
                            type: "get",
                            url: "{{route('brands.brands')}}",
                            success: function (data) {
                                $("#PC_brand").html(data);
                                $("#UpPcBrand").html(data);
                                $("#LaptopBrand").html(data);
                                $("#upLaptopBrand").html(data);
                                $("#serverBrand").html(data);
                                $("#upServerBrand").html(data);
                                $("#printerBrand").html(data);
                                $("#upPrinterBrand").html(data);
                                $("#screenBrand").html(data);
                                $("#upScreenBrand").html(data);
                                $("#barcodeBrand").html(data);
                                $("#upBarcodeBrand").html(data);
                                $("#accessPointBrand").html(data);
                                $("#upAccessPointBrand").html(data);
                                $("#modemBrand").html(data);
                                $("#upModemBrand").html(data);
                                $("#routerBrand").html(data);
                                $("#upRouterBrand").html(data);
                                $("#switchBrand").html(data);
                                $("#upSwitchBrand").html(data);
                                $("#modelBrand").html(data);
                            }
                        });
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

        {{---------------------------------------- End Add Brand Function --------------------------------------------}}

        {{--------------------------------------------- Add CPU Function ---------------------------------------------}}

        $(document).on('click', '#addCPUBtn', function (e) {
            e.preventDefault();
            let cpu_name = $('#CPUName').val();
            $.ajax({
                url: "{{ route('cpu.store') }}",
                method: "POST",
                data: {cpu_name: cpu_name},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addCPUModal').modal('hide');
                        $('#addCPUForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'CPU added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $.ajax({
                            type: "get",
                            url: "{{route('cpu.cpu')}}",
                            success: function (data) {
                                $("#PC_CPU").html(data);
                                $("#UpPcCpu").html(data);
                                $("#LaptopCPU").html(data);
                                $("#upLaptopCPU").html(data);
                                $("#serverCPU").html(data);
                                $("#upServerCPU").html(data);
                            }
                        });
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

        {{------------------------------------------ End Add CPU Function --------------------------------------------}}

        {{-------------------------------------------- Add GPU Function ----------------------------------------------}}

        $(document).on('click', '#addGPUBtn', function (e) {
            e.preventDefault();
            let gpu_name = $('#GPUName').val();
            $.ajax({
                url: "{{ route('gpu.store') }}",
                method: "POST",
                data: {gpu_name: gpu_name},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addGPUModal').modal('hide');
                        $('#addGPUForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'GPU added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $.ajax({
                            type: "get",
                            url: "{{route('gpu.gpu')}}",
                            success: function (data) {
                                $("#PC_GPU1").html(data);
                                $("#PC_GPU2").html(data);
                                $("#UpPcGpu1").html(data);
                                $("#UpPcGpu2").html(data);
                                $("#LaptopGPU1").html(data);
                                $("#LaptopGPU2").html(data);
                                $("#upLaptopGPU1").html(data);
                                $("#upLaptopGPU2").html(data);
                                $("#serverGPU1").html(data);
                                $("#serverGPU2").html(data);
                                $("#upServerGPU1").html(data);
                                $("#upServerGPU2").html(data);

                            }
                        });
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

        {{-------------------------------------------- End Add GPU Function ------------------------------------------}}

        {{---------------------------------------------- Add OS Function ---------------------------------------------}}

        $(document).on('click', '#addOSBtn', function (e) {
            e.preventDefault();
            let os_name = $('#OSName').val();
            $.ajax({
                url: "{{ route('operating_systems.store') }}",
                method: "POST",
                data: {os_name: os_name},
                success: function (res) {
                    if (res.status == 'success') {
                        $('#addOSModal').modal('hide');
                        $('#addOSForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Operating System added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $.ajax({
                            type: "get",
                            url: "{{route('operating_systems.operating_systems')}}",
                            success: function (data) {
                                $("#PC_OS").html(data);
                                $("#UpPcOS").html(data);
                                $("#LaptopOS").html(data);
                                $("#upLaptopOS").html(data);
                                $("#serverOS").html(data);
                                $("#upServerOS").html(data);
                            }
                        });
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

        {{------------------------------------------- End Add OS Function --------------------------------------------}}

    });

</script>
