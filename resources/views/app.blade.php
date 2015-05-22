<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<title>Fos</title>

	<link href="{{ asset('/admin/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/admin/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/admin/css/ionicons.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/admin/js/plugins/jquery.alert/alertify.core.css') }}" rel="stylesheet">
	<link href="{{ asset('/admin/css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body class="skin-blue">
    @include('admin.layouts.header')
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                    @yield('content')
                </div>
            </div>
        </section>
    </div>

	<!-- Scripts -->
	<script src="{{ asset('/admin/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/jquery.alert/alertify.min.js') }}"></script>
	<script src="{{ asset('/admin/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
