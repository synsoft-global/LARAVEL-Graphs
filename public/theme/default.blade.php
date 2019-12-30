<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CI-Reporting</title>

    <link rel="shortcut icon" href="img/favicon.svg">

	  
	<link rel="stylesheet" href="{!! asset('theme/fonts/open-sans/style.min.css') !!}"> <!-- common font  styles  -->
	<link rel="stylesheet" href="{!! asset('theme/fonts/universe-admin/style.css') !!}"> <!-- universeadmin icon font styles -->
	<link rel="stylesheet" href="{!! asset('theme/fonts/mdi/css/materialdesignicons.min.css') !!}"> <!-- meterialdesignicons -->
	<link rel="stylesheet" href="{!! asset('theme/fonts/iconfont/style.css') !!}"> <!-- DEPRECATED iconmonstr -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/flatpickr/flatpickr.min.css') !!}"> <!-- original flatpickr plugin (datepicker) styles -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/simplebar/simplebar.css') !!}"> <!-- original simplebar plugin (scrollbar) styles  -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/tagify/tagify.css') !!}"> <!-- styles for tags -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/tippyjs/tippy.css') !!}"> <!-- original tippy plugin (tooltip) styles -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/select2/css/select2.min.css') !!}"> <!-- original select2 plugin styles -->
	<link rel="stylesheet" href="{!! asset('theme/vendor/bootstrap/css/bootstrap.min.css') !!}"> <!-- original bootstrap styles -->
	<link rel="stylesheet" href="{!! asset('theme/css/style.min.css') !!}" id="stylesheet"> <!-- universeadmin styles -->
	<script src="{!! asset('theme/js/ie.assign.fix.min.js') !!}"></script>
</head>
<body>
    <div class="navbar navbar-light navbar-expand-lg">
    <button class="sidebar-toggler" type="button">
      <span class="ua-icon-sidebar-open sidebar-toggler__open"></span>
      <span class="ua-icon-alert-close sidebar-toggler__close"></span>
    </button>

    <span class="navbar-brand">
      <a href="/"><img src="images/newlogo.png" alt="" class="navbar-brand__logo"></a>
      <span class="ua-icon-menu slide-nav-toggle"></span>
    </span>

    <span class="navbar-brand-sm">
      <a href="/"><img src="img/logo-sm.png" alt="" class="navbar-brand__logo"></a>
      <span class="ua-icon-menu slide-nav-toggle"></span>
    </span>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse">
      <span class="ua-icon-navbar-open navbar-toggler__open"></span>
      <span class="ua-icon-alert-close navbar-toggler__close"></span>
    </button>

    <!--<?php //$this->load->view('top-navbar'); ?>-->
  </div>

  <div class="page-wrap"> 
        @include('theme.header')
        @include('theme.sidebar')
   
        @yield('content')
        <!-- /#page-wrapper -->
    </div>

    <script src="{!! asset('theme/vendor/echarts/echarts.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/jquery/jquery.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/popper/popper.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/select2/js/select2.full.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/simplebar/simplebar.js') !!}"></script>
	<script src="{!! asset('theme/vendor/text-avatar/jquery.textavatar.js') !!}"></script>
	<script src="{!! asset('theme/vendor/tippyjs/tippy.all.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/flatpickr/flatpickr.min.js') !!}"></script>
	<script src="{!! asset('theme/vendor/wnumb/wNumb.js') !!}"></script>
	<script src="{!! asset('theme/js/main.js') !!}"></script>
	<script src="{!! asset('theme/vendor/jquery-circle-progress/circle-progress.min.js') !!}"></script>
	<script src="{!! asset('theme/js/preview/default-dashboard.min.js') !!}"></script>
	<script src="{!! asset('theme/js/preview/settings-panel.min.js') !!}"></script>
	<script src="{!! asset('theme/js/preview/slide-nav.min.js') !!}"></script>

</body>
</html>