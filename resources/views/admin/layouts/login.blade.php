<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>Fos</title>

    <link href="{{ asset('/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/admin/css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-black">
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/admin/js/user.js') }}"></script>
</body>
</html>
