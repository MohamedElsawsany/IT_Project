<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                    <small class="float-right">Date:{{$user->updated_at}}</small>
            </div>
            <!-- /.col -->
            <div class="col-12">
                <h2 class="page-header">
                    <img src="{{asset('imgs/IT_LOGO.jpg')}}" alt="IT_Nassargroup"
                         style="width: 100px;border-radius: 10px;"> IT Nassar group Dep.
                    <!--          <i class="fas fa-globe"></i> AdminLTE, Inc.-->
                    <small class="float-right">Receiving Custody</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Eng: {{$user->name}}</strong><br>
                    {{$user->governorate_name}} - {{$user->site_name}}<br>
                    IT Department<br>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>MR/MS : {{$employee->emp_name}}</strong>
                </address>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Serial.No</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            {{$barcode->serial_number}}
                        </td>
                        <td>
                            Barcode Scanner
                        </td>
                        <td>
                            {{$barcode->brand_name}}
                        </td>
                        <td>
                            {{$barcode->model_name}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-12">
                <p class="lead">1- I will be the official user of this device.</p><br>
                <p class="lead">2- I won't give this device for another person.</p><br>
                <p class="lead">3- I'm responsible to return it upon request or when leaving work.</p><br>
                <p class="lead">4- I will pay for any damages happen to it.</p><br>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">The recipient's signature:</p>
                <p class="lead">..............................................</p>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-12">
                <strong>Notes :</strong><br>
                <p class="lead">By signing this argeement,the employee responsibility(for his\her device) is to demonstrate proper use of specified equipment.
                    the employee also understands that this device is for business usage only.
                    All specified equipment is the property of Nassar Group.</p>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
    window.addEventListener("load", window.print());
</script>
</body>
</html>
