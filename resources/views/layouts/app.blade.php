<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{!! asset('theme/img/favicon.ico') !!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('theme/img/favicon.ico') !!}" type="image/x-icon">

    <title>
        
        {{get_page_title(Request::segment(1),Request::segment(2))}}
            </title>

    <link rel="shortcut icon" href="{!! asset('theme/img/favicon.png') !!}">
     @if(Request::segment(1) == 'dashboard')
       <link rel="stylesheet" href="{!! asset('jquery.gridly/stylesheets/jquery.gridly.css') !!}" id="stylesheet"> 
     @endif
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
      <link rel="stylesheet" href="{!! asset('theme/vendor/date-range-picker/daterangepicker.css') !!}" id="stylesheet">
      <link rel="stylesheet" href="{!! asset('theme/vendor/jodit/jodit.min.css') !!}" id="stylesheet">
       <link rel="stylesheet" href="{!! asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}" id="stylesheet">
      <link rel="stylesheet" href="{!! asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker-standalone.css') !!}" id="stylesheet">

    
    <link rel="stylesheet" href="{!! asset('theme/css/style.min.css') !!}" id="stylesheet"> 
    <link rel="stylesheet" href="{!! asset('css/datatables.min.css') !!}" id="stylesheet"> 
    <link rel="stylesheet" href="{!! asset('css/flag-icon.min.css') !!}" id="stylesheet"> 
    <link rel="stylesheet" href="{!! asset('theme/vendor/sumo-select/sumoselect.min.css') !!}" id="stylesheet">
  
    <!-- custom css  -->
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/custom.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/selectize.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/selectize.bootstrap3.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/jquery-ui.css') !!}">
    <link rel="stylesheet" href="{!! asset('bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
 <!--    <link rel="stylesheet" href="{!! asset('css/style_slider.css') !!}"> --> <!-- common font  styles  -->

    <link rel="stylesheet" href="{!!asset('css/lsb.css')!!}" />

    <link rel="stylesheet" href="{!! asset('css/font-awesome.min.css') !!}">

    <script src="{!! asset('theme/vendor/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/jquery-ui/jquery-ui.min.js') !!}"></script>

    <script src="{!! asset('theme/vendor/select2/js/select2.full.min.js') !!}"></script>
    
    
</head>
<body>
    <div class="page-preloader js-page-preloader">
      <div class="page-preloader__logo">
        <img src="{!! asset('theme/img/logo-black-lg.svg') !!}" alt="" class="page-preloader__logo-image">
      </div>
      <!--<div class="page-preloader__desc">Reporting Software</div>-->
      <div class="page-preloader__loader">
       <!-- <div class="page-preloader__loader-heading">Loading....</div>-->
        <div class="progress progress-rounded page-preloader__loader-progress">
          <div id="page-loader-progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
              
          </div>
        </div>
      </div>     
    </div>

   
    <script type="text/javascript">
        var timeout = "500";    
        var string_limit = "500";    
        var store_start_date = "{{session('store_start_date')}}";    
        var store_timezone = "{{session('store_timezone')}}";    
        var countries = JSON.parse('{!!json_encode(get_countries())!!}');    
        var currency = "{!!get_currency_symbol(session('store_currency'))!!}";       
        var SOCIAL_IMAGE_UPLOAD_LIMIT  = "{{SOCIAL_IMAGE_UPLOAD_LIMIT}}";
        var PRODUCT_IMAGE_UPLOAD_LIMIT  = "{{PRODUCT_IMAGE_UPLOAD_LIMIT}}";
        var auth_user_id  = "{{Auth::check()?Auth::user()->id:''}}";
        var auth_user_role  = "{{Auth::check()?Auth::user()->role->slug:''}}";
    </script>
  

    @if(Auth::check())
        @include('layouts.top-navbar')
    @endif
    
    <div class="page-wrap">
    @if(Auth::check()) 
        @include('layouts.sidebar')
    @endif
    @yield('content')
        <!-- /#page-wrapper -->
    </div>
    

  
    <script src="{!! asset('js/jquery.lazyload.min.js') !!}"></script>
  
    <script src="{!! asset('js/validate.min.js') !!}"></script>
    
    <script src="{!! asset('theme/vendor/popper/popper.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.min.js') !!}"></script>

    
    <script type="text/javascript" src="{!! asset('bootstrap-datetimepicker/js/moment/min/moment.min.js') !!}"></script>
   <script type="text/javascript" src="{!! asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/simplebar/simplebar.js') !!}"></script>


    <script src="{!! asset('theme/vendor/jodit/jodit.min.js') !!}"></script>

    <script src="{!! asset('theme/vendor/text-avatar/jquery.textavatar.js') !!}"></script>
    <script src="{!! asset('theme/vendor/tippyjs/tippy.all.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/flatpickr/flatpickr.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/wnumb/wNumb.js') !!}"></script>
    <script src="{!! asset('theme/js/main.js') !!}"></script>
    
    <script src="{!! asset('theme/vendor/momentjs/moment-with-locales.min.js')!!}"></script>
    <script src="{!! asset('theme/vendor/date-range-picker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('js/date-range-picker.js')!!}"></script>
   
    <script src="{!! asset('theme/js/preview/settings-panel.min.js') !!}"></script>
    <script src="{!! asset('theme/js/preview/slide-nav.min.js') !!}"></script>

    <script src="{!! asset('theme/vendor/datatables/datatables.min.js') !!}"></script>
    <script src="{!! asset('theme/js/preview/datatables.min.js') !!} "></script>
    <script src="{!! asset('bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!} "></script>
    

   

     <script src="{!! asset('js/selectize.min.js') !!}"></script>

     <script src="{!! asset('js/common.js') !!}"></script>

    <script src="{!! asset('theme/js/preview/select.js') !!}"></script>    
    <script src="{!! asset('theme/vendor/select2/js/select2.min.js') !!}"></script>    
    <script src="{!! asset('theme/vendor/sumo-select/jquery.sumoselect.min.js') !!}"></script>
    <script src="{!! asset('theme/js/preview/select.min.js') !!}"></script>
    
    <script type="text/javascript">
        var site_url = "{{url('/')}}";    
        var asset_url = "{{asset('/')}}";    
        var report_url_segment = "{{Request::segment(2)}}";
    </script>


    <script type="text/javascript">
        var exp_total_limit = "{{Session::get('download_limit')}}";

        <?php 
        foreach (__('messages.jquery_messages') as $key => $value) {
        ?>
            var msg_{{$key}} = "{!!$value!!}";
        <?php    
        }
        ?>
    </script>


    
    <script src="{!! asset('js/custom.js') !!}"></script>
  
    @if(Request::segment(1) == 'reports' && Request::segment(2) == 'orders')
    <script src="{!! asset('js/chart.js') !!}"></script>
    <script src="{!! asset('js/report-common.js') !!}"></script>
    <script src="{!! asset('js/report_order.js') !!}"></script>
    @endif    
    
    <script src="{!! asset('theme/js/ie.assign.fix.min.js') !!}"></script>
   
    
    <!-- <script src="{!! asset('theme/vendor/select2/js/select2.full.min.js') !!}"></script> -->
     <script src="{!! asset('js/underscore-min.js') !!}"></script>
    
     
    </script>
    <script src="{!! asset('js/lsb.js')!!}"></script>

    
    <script src="{!! asset('theme/vendor/sweet-alert/sweetalert.min.js')!!}"></script>
    <script src="{!! asset('theme/js/preview/sweet-alert.min.js')!!}"></script>
    <script type="text/javascript">
        /*timpicker */
        $("#send_on").flatpickr({
            'minuteIncrement': 30,
            'mode': "multiple",
            });

         $('.datetimepicker').datetimepicker();
       
        $(document).on('focus',"#flatpickr", function(){
            $(this).flatpickr();
        })
        $(document).on('focus',".flatpickr", function(){
            $(this).flatpickr();
        })
        $(document).on('focus',".datetimepicker", function(){
            $(this).datetimepicker({
                format: 'YYYY-MM-DD hh mm A',
            });
        })

        $('.js-scrollable').each(function () {
            new SimpleBar(this);
          });     
        
    </script>
     @yield('footer_scripts')    
</body>
</html>