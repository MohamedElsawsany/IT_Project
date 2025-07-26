<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end screens datatables function ------------------------------------------}}
        $('#mobilesSimTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var mobilesSimTable = $("#mobilesSimTable").DataTable({
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
                    title: 'Mobiles Sim Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Mobiles Sim Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('mobiles.mobiles')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't1.serial_number'},
                {data: 'mobile_number', name: 't1.mobile_number'},
                {data: 'ip', name: 't1.ip'},
                {data: 'emp_name', name: 't2.emp_name'},
                {data: 'creator', name: 't3.name'},
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

        $(document).on('click', '#addMobileSimBtn', function (e) {
            e.preventDefault();
            let serial_number = $('#mobileSimSerialNumber').val();
            let mobileSimNumber = $('#mobileSimNumber').val();
            let mobileSimIP = $('#mobileSimIP').val();
            let mobileSimAssignTo = $('#mobileSimAssignTo').val();
            $.ajax({
                url: "{{ route('mobiles.store') }}",
                method: "POST",
                data: {
                    serial_number: serial_number,
                    mobileSimNumber: mobileSimNumber,
                    mobileSimIP: mobileSimIP,
                    mobileSimAssignTo: mobileSimAssignTo
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $("#mobileSimAssignTo").select2("val", "0");
                        $('#addMobileSimModal').modal('hide');
                        $('#addMobileSimForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Mobile Sim added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        mobilesSimTable.ajax.reload(null, false);
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

        $(document).on('click', '#editMobileSimLink', function (e) {
            e.preventDefault();
            let editMobileSimId = $(this).data('mobile_sim_id');
            let editMobileSimSerialNumber = $(this).data('mobile_sim_serial_number');
            let editMobileSimIP = $(this).data('mobile_sim_ip');
            let editMobileSimNumber = $(this).data('mobile_sim_number');
            let editMobileSimEmpName = $(this).data('mobile_sim_emp_name');
            $('#upMobileSimId').val(editMobileSimId);
            $('#upMobileSimSerialNumber').val(editMobileSimSerialNumber);
            $('#upMobileSimIP').val(editMobileSimIP);
            $('#upMobileSimNumber').val(editMobileSimNumber);
            $('#upMobileSimAssignTo').val(editMobileSimEmpName);
            $('#upMobileSimAssignTo').select2().trigger('change');
        });

        {{------------------------------------- END edit Screen model ------------------------------------------------}}

        {{----------------------------------------------- Update Screen ----------------------------------------------}}

        $(document).on('click', '#upMobileSimBtn', function (e) {
            e.preventDefault();
            let upMobileSimId = $('#upMobileSimId').val();
            let serial_number = $('#upMobileSimSerialNumber').val();
            let upMobileSimAssignTo = $('#upMobileSimAssignTo ').val();
            let upMobileSimIP = $('#upMobileSimIP ').val();
            let upMobileSimNumber = $('#upMobileSimNumber').val();
            $.ajax({
                url: "{{ route('mobiles.update') }}",
                method: 'put',
                data: {
                    upMobileSimId: upMobileSimId,
                    upMobileSimAssignTo: upMobileSimAssignTo,
                    upMobileSimIP: upMobileSimIP,
                    upMobileSimNumber: upMobileSimNumber,
                    serial_number: serial_number
                },
                success: function (res) {
                    if (res.status == 'success') {
                        $("#upMobileSimAssignTo").select2("val", "0");
                        $('#editMobileSimModal').modal('hide');
                        $('#editMobileSimForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Mobile Sim edited successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        mobilesSimTable.ajax.reload(null, false);
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

        $(document).on('click','#deleteMobileSimLink',function(e){
            e.preventDefault();
            let id =$(this).data('mobile_sim_id');
            $('#deleteMobileSimId').val(id);
        });

        {{--------------------------------------- end view delete screen model----------------------------------------}}

        {{------------------------------------- delete screen function -----------------------------------------------}}

        $(document).on('click','#deleteMobileSimBtn',function(e){
            e.preventDefault();
            let id=$('#deleteMobileSimId').val();
            $.ajax({
                url:"{{ route('mobiles.soft_delete') }}",
                method:'delete',
                data:{id:id},
                success:function(res){
                    if (res.status=='success'){
                        $('#deleteMobileSimModal').modal('hide');
                        $('#deleteMobileSimForm')[0].reset();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Mobile Sim deleted successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        mobilesSimTable.ajax.reload( null, false );
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

        $(document).on('click', '#refreshMobilesSimTable', function (e) {
            e.preventDefault();
            mobilesSimTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh screens table -------------------------------------------}}


        {{----------------------------------------------- Screens Select2 -------------------------------------------------}}

        $("#mobileSimAssignTo").select2({
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

        $("#upMobileSimAssignTo").select2({
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
