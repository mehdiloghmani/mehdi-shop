<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>پنل مدیریت</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="/admin/dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="/admin/dist/css/custom-style.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


@yield('content')

    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE -->
        <script src="/admin/dist/js/adminlte.js"></script>

        <!-- OPTIONAL SCRIPTS -->
        <script src="/admin/plugins/chart.js/Chart.min.js"></script>
        <script src="/admin/dist/js/demo.js"></script>
        <script src="/admin/dist/js/pages/dashboard3.js"></script>

        <script src="/admin/plugins/ckeditor/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );

        </script>


        </body>
        </html>
