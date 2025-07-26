<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end screens datatables function ------------------------------------------}}
        $('#deliveredScreensTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });
        var deliveredScreensTable = $("#deliveredScreensTable").DataTable({
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
                    title: 'Delivered Screens Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Delivered Screens Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('screens.delivered_screen')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't2.serial_number'},
                {data: 'brand_name', name: 't4.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'emp_name', name: 't11.emp_name'},
                {data: 'department_name', name: 't15.department_name'},
                {data: 'governorate_name', name: 't8.governorate_name'},
                {data: 'site_name', name: 't6.site_name'},
                {data: 'activity_name', name: 't7.activity_name'},
                {data: 'creator', name: 't10.name'},
                {data: 'backed_by', name: 't12.name'},
                {
                    data: 'created_at', name: 't1.created_at', render: function (value) {
                        if (value == null) {
                            return value;

                        } else {
                            return moment(value).format('YYYY-MM-DD');

                        }
                    }
                },
                {
                    data: 'updated_at', name: 't1.updated_at', render: function (value) {
                        if (value == null) {
                            return value;

                        } else {
                            return moment(value).format('YYYY-MM-DD');

                        }
                    }
                },
                {
                    data: 'action', name: 'action', searchable: false
                }
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

        {{-------------------------------------- refresh screens table -----------------------------------------------}}

        $(document).on('click', '#refreshDeliveredScreensTable', function (e) {
            e.preventDefault();
            deliveredScreensTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh screens table -------------------------------------------}}

        {{----------------------------------     Back to stock      ----------------------------------}}
        $(document).on('click', '#returnScreenToStock', function (e) {
            e.preventDefault();
            let deliveredId = $(this).data('delivered_id');
            let screenId = $(this).data('screen_id');
            $.ajax({
                url: "{{route('screens.back_to_stock')}}",
                method: 'put',
                data: {deliveredId: deliveredId, screenId: screenId},
                success: function (res) {

                    if (res.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Screen restored to stock successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        deliveredScreensTable.ajax.reload(null, false);

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
        {{----------------------------------     End Back to stock      ----------------------------------}}
    });

</script>

