<div class="sidebar-section">
  <div class="sidebar-section__scroll">
    <?php
    /*
      Logged in user details
    */
    ?>
    <div class="simplebar-track vertical" style="visibility: visible;">
      <div class="simplebar-scrollbar" style="top: 2px; height: 62px;"></div>
    </div>
    <!--<div class="sidebar-user-a">
     
    </div>-->
    <?php
    /*
      Sidebar menu for logged-in user
    */
    ?>
    <?php 
      $sidebar_permission = checkPermission(Auth::user()->role->slug, 'sidebar_menu'); 
    ?>
    <div> 

      <ul class="sidebar-section-nav">
        @if(empty(in_array('reports', $sidebar_permission)))  
        <li class="sidebar-section-nav__item {{(Request::segment(1)=='reports')?'is-active':''}}">
          <a class="sidebar-section-nav__link sidebar-section-nav__link-dropdown" href="#" >
            <span class="sidebar-section-nav__item-icon ua-icon-charts"></span>
            <span class="sidebar-section-nav__item-text">Reports</span>
          </a>
          <ul class="sidebar-section-subnav" style="{{(Request::segment(1)=='reports')?'display: block;':''}}">
           
            @if(empty(in_array('reports/orders', $sidebar_permission)))  
            <li class="sidebar-section-subnav__item"><a class="sidebar-section-subnav__link {{(Request::segment(2)=='orders')?'is-active':''}}" href="{{url('reports/orders')}}">Orders</a></li>
            @endif
           
          </ul>
        </li>
        @endif
      </ul>
    </div>
  </div>
</div>

<!-- /.navbar-static-side -->