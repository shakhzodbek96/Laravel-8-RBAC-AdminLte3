<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@lang('panel.site_title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
	<!-- My styles -->
	<link rel="stylesheet" href="{{asset('plugins/bootstrap_my/my_style.css')}}">
	<!-- Responsive data tables -->
	<link rel="stylesheet" href="{{ asset('plugins/Responsive-2.2.3/css/responsive.dataTables.min.css') }}">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	<link rel="icon" href="/consImages/logoU.png ">
</head>

<body class="{{ auth()->user()->theme()['body'] ?? '' }} hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper" style="display: block">
	<!-- Navbar-->
	<nav class="main-header navbar navbar-expand {{ auth()->user()->theme()['navbar'] ?? 'navbar-light' }}">

		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
		</ul>

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-user"></i>
                    @if(auth()->user())
                        {{ auth()->user()->name }}
                    @endif
                </a>
				<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
					<li>
						@if(auth()->user())
                            <a href="{{ route('userEdit',auth()->user()->id) }}" class="dropdown-item">
                                <i class="fas fa-cogs"></i> @lang('global.settings')
                            </a>
                        @endif
					</li>
					<li>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						<a href="#" class="nav-link" role="button" onclick="
                                    event.preventDefault();
                                    document.getElementById('logout-form').submit();">
							<i class="fas fa-sign-out-alt"></i> @lang('global.logout')
						</a>
					</li>
				</ul>
			</li>
		</ul>
        <div class="sl-nav">
            <i class="sl-flag flag-{{ App::getLocale('locale') }}"></i>
            <ul>
                <li class="nav-link" style="padding-left: 0">{{ strtoupper(App::getLocale('locale')) }}
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    <div class="triangle"></div>
                    <ul>
                        <li><a href="/language/uz"><i class="sl-flag flag-uz"><div id="uzbek"></div></i> <span>Uz</span></a></li>
                        <li><a href="/language/ru"><i class="sl-flag flag-ru"><div id="russian"></div></i> <span>Ru</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
	</nav>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<aside class="main-sidebar elevation-1 {{ auth()->user()->theme()['sidebar'] ?? 'sidebar-dark-primary' }}">
		<!-- Brand Logo -->
		<a href="#" class="brand-link">
			<img src="{{ asset('consImages/logoU.png') }}" alt="Unired Logo" class="brand-image img-circle elevation-3"
				 style="opacity: .8">
			<span class="brand-text font-weight-light">@lang('panel.site_title')</span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar Menu -->
		@include('layouts.sidebar')
		<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
	@yield('content')
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="https://t.me/GafurovShakhzodbek">Alpha-Group </a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('plugins/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2-theme-bootstrap-4/sweet-alerts.min.js') }}"></script>
<!-- MyJs -->
<script src="{{asset('plugins/bootstrap_my/myScripts.js')}}" type="text/javascript"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

    //Clear form filters
    $("#reset_form").on('click',function () {
        $('form :input').val('');
        $("form :input[class*='like-operator']").val('like');
        $( "div[id*='_pair']" ).hide();
    });

    function onSelectSetValue(input_name, input_val) {
        $("form :input[name="+input_name+"]").val(input_val);
    }
</script>
@if(session('_message'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: "{{ session('_type') }}",
            title: "{{ session('_message') }}",
            showConfirmButton: false,
            timer: {{session('_timer') ?? 5000}}
        });
    </script>
    @php(message_clear())
@endif
@yield('scripts')
</body>
