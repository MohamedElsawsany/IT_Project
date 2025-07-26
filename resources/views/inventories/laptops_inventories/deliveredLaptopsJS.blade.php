<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        {{------------------------------------- laptops datatables function ------------------------------------------}}
        $('#deliveredLaptopsTable tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="text-align: center;" placeholder="Search ' + title + '" />');
        });


        var deliveredLaptopsTable = $("#deliveredLaptopsTable").DataTable({
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
                    title: 'Delivered Laptops Information'
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    title: 'Delivered Laptops Information'
                },
                'colvis'
            ],
            ajax: {
                url: "{{route('laptops.delivered_laptop')}}",
                type: "post",
                dataType: 'json'
            },
            deferRender: true,
            columns: [
                {data: 'id', name: 't1.id'},
                {data: 'serial_number', name: 't2.serial_number'},
                {data: 'brand_name', name: 't4.brand_name'},
                {data: 'model_name', name: 't3.model_name'},
                {data: 'emp_name', name: 't10.emp_name'},
                {data: 'department_name', name: 't15.department_name'},
                {data: 'governorate_name', name: 't8.governorate_name'},
                {data: 'site_name', name: 't6.site_name'},
                {data: 'activity_name', name: 't7.activity_name'},
                {data: 'creator', name: 't9.name'},
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

        {{------------------------------------ End laptops datatables function ---------------------------------------}}

        {{---------------------------------------- refresh laptops table ---------------------------------------------}}

        $(document).on('click', '#refreshDeliveredLaptopsTable', function (e) {
            e.preventDefault();
            deliveredLaptopsTable.ajax.reload(null, false);
        });

        {{---------------------------------------- end refresh laptops table -----------------------------------------}}



        {{----------------------------------     Back to stock      ----------------------------------}}
        $(document).on('click', '#returnLaptopToStock', function (e) {
            e.preventDefault();
            let deliveredId = $(this).data('delivered_id');
            let laptopId = $(this).data('laptop_id');
            $.ajax({
                url: "{{route('laptops.back_to_stock')}}",
                method: 'put',
                data: {deliveredId: deliveredId, laptopId: laptopId},
                success: function (res) {

                    if (res.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Laptop restored to stock successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        deliveredLaptopsTable.ajax.reload(null, false);

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

