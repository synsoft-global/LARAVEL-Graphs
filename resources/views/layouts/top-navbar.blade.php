  <!-- Start toast pop up -->
  <div id="success-msg-alert">       
      <div class="alert alert-success hide_alert" role="alert"  style="{{Session::has('successmessage')?'display: block;':'display: none;'}}">
        <span class="alert-icon ua-icon-info"></span>
        <strong class="msg">@if(Session::has('successmessage')){{Session::get('successmessage')}}@endif</strong>
        <span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
      </div>
      <div class="alert alert-info hide_alert" role="alert"  style="{{Session::has('infomessage')?'display: block;':'display: none;'}}">
        <span class="alert-icon ua-icon-info"></span>
         <strong class="msg">@if(Session::has('infomessage')){{Session::get('infomessage')}}@endif</strong>
        <span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
      </div>
      <div class="alert alert-warning hide_alert" role="alert"  style="{{Session::has('warnmessage')?'display: block;':'display: none;'}}">
        <span class="alert-icon ua-icon-info"></span>
        <strong class="msg">@if(Session::has('warnmessage')){{Session::get('warnmessage')}}@endif</strong>
        <span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
      </div>
      <div class="alert alert-danger hide_alert" role="alert"  style="{{Session::has('errormessage')?'display: block;':'display: none;'}}">
        <span class="alert-icon ua-icon-info"></span>
         <strong class="msg">@if(Session::has('errormessage')){{Session::get('errormessage')}}@endif</strong>
        <span class="close alert__close ua-icon-alert-close" data-dismiss="alert"></span>
      </div>   
  </div>
  <!-- End toast pop up -->

  
  <div class="navbar navbar-light navbar-expand-lg">

  <button class="sidebar-toggler" type="button">
    <span class="ua-icon-sidebar-open sidebar-toggler__open"></span>
    <span class="ua-icon-alert-close sidebar-toggler__close"></span>
  </button>

  <span class="navbar-brand">
    <a href="{{url('/')}}"><img src="{!! asset('theme/img/logo.svg') !!}" alt="" class="navbar-brand__logo"></a>
    <span class="ua-icon-menu slide-nav-toggle"></span>
  </span>

  <span class="navbar-brand-sm">
    <a href="{{url('/')}}"><img src="{!! asset('theme/img/logo-sm.png') !!}" alt="" class="navbar-brand__logo"></a>
    <span class="ua-icon-menu slide-nav-toggle"></span>
  </span>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse">
    <span class="ua-icon-navbar-open navbar-toggler__open"></span>
    <span class="ua-icon-alert-close navbar-toggler__close"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbar-collapse">
    <div class="navbar__menu">      
    </div>    
    <div class="dropdown navbar-dropdown">
      <a class="dropdown-toggle navbar-dropdown-toggle navbar-dropdown-toggle__user" data-toggle="dropdown" href="#">
        <img src="{!! asset('uploads/profile_img/') !!}/{{!empty(Auth::user()->profile_image)?Auth::user()->profile_image:'blank_img.jpg'}}" alt="" class="navbar-dropdown-toggle__user-avatar">
        <span class="navbar-dropdown__user-name">{{Auth::user()->name}}</span>
      </a>
      <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu__user">
     
        <a class="dropdown-item navbar-dropdown__item" href="{{ url('logout') }}" > {{ __('Logout') }} </a>   
      </div>
    </div>
  </div>
</div>