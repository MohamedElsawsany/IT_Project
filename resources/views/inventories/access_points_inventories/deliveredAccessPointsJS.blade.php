<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{--------------------------------- end Routers datatables function ------------------------------------------}}
        $('#deliveredAccessPointsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });

        var deliveredAccessPointsTable = $("#deliveredAccessPointsTable").DataTable({
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
                    title: 'Delivered Access Points Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Delivered Access Points Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('access_points.delivered_access_points')}}",
                type: "POST",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't9.serial_number'},
                {data: 'brand_name', name: 't2.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'emp_name', name: 't15.emp_name'},
                {data: 'department_name', name: 't16.department_name'},
                {data: 'governorate_name', name: 't8.governorate_name'},
                {data: 'site_name', name: 't6.site_name'},
                {data: 'activity_name', name: 't7.activity_name'},
                {data: 'creator', name: 't10.name'},
                {data: 'backed_by', name: 't11.name'},
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

        {{--------------------------------- end Access Points datatables function ------------------------------------------}}

        {{-------------------------------------- refresh Access Points table -----------------------------------------------}}

        $(document).on('click', '#refreshDeliveredAccessPointsTable', function (e) {
            e.preventDefault();
            deliveredAccessPointsTable.ajax.reload(null, false);
        });

        {{-------------------------------------- end refresh Access Points table -------------------------------------------}}
        {{----------------------------------     Back to stock      ----------------------------------}}
        $(document).on('click', '#returnAccessPointToStock', function (e) {
            e.preventDefault();
            let deliveredId = $(this).data('delivered_id');
            let accessPointId = $(this).data('access_point_id');
            $.ajax({
                url: "{{route('access_points.back_to_stock')}}",
                method: 'put',
                data: {deliveredId: deliveredId, accessPointId: accessPointId},
                success: function (res) {

                    if (res.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Access Point restored to stock successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        deliveredAccessPointsTable.ajax.reload(null, false);

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
