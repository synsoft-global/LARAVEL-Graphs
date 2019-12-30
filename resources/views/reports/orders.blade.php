@extends('layouts.app')
@section('content')

<style type="text/css">
  
.main-container {
    margin:0 !important;
    width: 100% !important;
    padding: 10px;
       margin-bottom:10px !important;
}
.order_sort_icon {
    opacity: 0.4;
}
.order_sort_icon.active {
    opacity: 1;
}

</style>

<div class="page-content product-grp-container reports-revenue-grid order-rve-gph-grid page-loading" id="page_loading" style="display: none;">

<!--start header row -->
<div class="row top-subnav navbar-fixed-top "> 
<div class="col-sm-12 col-md-12 col-lg-4 subnav-left "> 
  <div class="title"><strong>Report</strong> Orders by Date</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-8 float-left subnav-right subnav-flex">

   {!!view("products.ajax.topright")->render()!!}

</div>
</div>

<!--end header row -->






<!-- start typography section -->

<div class="container-fluid reports-revenue-container">
  <div class="row">
      <div class="col-12">
        <div class="main-container mb-0">
       


              <div class="report-about">
                <p class="mb-1">  This report looks at orders created between 
                  <span id="date-data"></span>
                </p>
                <p>
                  <strong>Net sales </strong>
                   
                   is an order's <em>total gross</em> less its taxes, fees, shipping, and refunds (including refunds made after <span id="order_refunds_date"></span>).
                </p>
          </div>

          </div>
        </div>
  </div>
</div>

<!--end typography section-->


<!--start grags sections-->

  <div class="container-fluid" >
  <div class="row">
      
      <div class="col-sm-12 col-md-12 col-lg-8" id="order-chart">

       <div class="d-flex justify-content-center my-3 width100 pull-left">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div> 
      </div> 
         <!-- end main-container-->
      </div>
        <!-- end col-8 -->


        <div class="col-sm-12 col-md-12 col-lg-4" id="order-sidewidget">
          <div class="d-flex justify-content-center my-3 width100 pull-left">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div> 
        </div>
        <!-- end col-4 -->


    </div>
  </div>

<!--end grags sections-->



<!-- start widgets section-->
<div class="container-fluid reports-revenue-container pt-0" id="order-widget">
<div class="d-flex justify-content-center my-3 width100 pull-left">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div> 

</div>
<!--end widgets section -->



<!--start another widget section -->
<div class="container-fluid reports-revenue-container pt-0 orders-report-main" id="order_monthly_net">
  <div class="d-flex justify-content-center my-3 width100 pull-left">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>    
</div>

<!--end another widget section-->



<!--start New vs. Returning Customers section -->
      <div class="container-fluid ">
          <div class="row">
              <div class="col-12">
                  <div class="main-container rve-gph-grid orderby-revenue-grid" id="orders_customers_type">
                     <div class="d-flex justify-content-center my-3 width100 pull-left">
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>                       
                  </div>
                           <!-- end main-container-->
                </div>
          </div>
        </div>


<!--end New vs. Returning Customers section -->

  <!--start Orders grouped by Status section -->
  <div class="container-fluid " id="order-status-grouped">
    
    <div class="d-flex justify-content-center my-3 width100 pull-left">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> 
  </div>
  <!--end Orders grouped by Status section -->

  <!-- start Orders grouped by Payment Method ID Payment Method Title -->
  <div class="container-fluid " id="order_payment_table">    
    <div class="d-flex justify-content-center my-3 width100 pull-left">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> 
  </div>
  <!-- end Orders grouped by Payment Method ID Payment Method Title -->


<!-- start Orders grouped by 4 buttons -->
  <div class="container-fluid " id="order_billing_table">
    <div class="d-flex justify-content-center my-3 width100 pull-left">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> 
  </div>
<!-- end Orders grouped by 4 buttons -->


<!-- start Orders grouped by 4 buttons -->
 <div class="container-fluid" id="order_shipping_table">
    <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-center my-3 width100 pull-left">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> 
 
       </div>
    </div>
  </div>


<!-- end Orders grouped by 4 buttons -->
<div class="container-fluid ">
  <div class="row">
  <div class="col-sm-6">
    <div class="order-item-distribution main-container rve-gph-grid">
      <div class="card ">
        <div class="header clearfix weekheader">
          <h3>Item count distribution</h3> 
          <div class="right">            
          </div>
        </div> 
        <div class="inner has-list-table">
          <div>
            <div class="chart p-5" id="chart_item_count">
               <div class="loading">
                <div class="d-flex justify-content-center my-3 width100 pull-left">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div> 
                 
              </div>
              <canvas id="chart-chart_item_count"></canvas>
               
               </div>
             </div>
           </div>
             </div>
           </div>
         </div> 
          <div class="col-sm-6">
            <div class="order-item-distribution main-container rve-gph-grid">
              <div class="card ">
                <div class="header clearfix weekheader">
                  <h3>Order value distribution <i data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Using order gross total." data-tippy-placement="right" class="fa fa-info-circle mx-2" aria-hidden="true"></i></h3> 
                  <div class="right">            
                  </div>
                </div> 
                <div class="inner has-list-table">
                  <div>
                    <div class="chart p-5" id="chart_order_count">
                      <div class="loading">
                        <div class="d-flex justify-content-center my-3 width100 pull-left">
                        <div class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                            
                        </div>
                      </div> 
                    </div>
                    <canvas id="chart-chart_order_count"></canvas>
                       
                       </div>
                     </div>
                   </div>
                     </div>
                   </div>
         </div> 
      </div>
  </div>

  <div class="container-fluid ">
  <div class="row">
  <div class="col-sm-6">
    <div class="order-item-distribution main-container rve-gph-grid">
      <div class="card ">
        <div class="header clearfix weekheader">
          <h3>Spend by day <i data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Using order gross total." data-tippy-placement="right" class="fa fa-info-circle mx-2" aria-hidden="true"></i></h3> 
          <div class="right">            
          </div>
        </div> 
        <div class="inner has-list-table">
          <div>
            <div class="chart p-5" id="chart_spend_by_day">
              <div class="loading">
                  <div class="d-flex justify-content-center my-3 width100 pull-left">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div> 
               
              </div>
                 <canvas id="chart-chart_spend_by_day"></canvas>
               </div>
             </div>
           </div>
             </div>
           </div>
         </div> 
          <div class="col-sm-6">
            <div class="order-item-distribution main-container rve-gph-grid">
              <div class="card ">
                <div class="header clearfix weekheader">
                  <h3>Spend by hour <i data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Using order gross total. A sale at 9.30AM would be counted between 9AM to 10AM" data-tippy-placement="right" class="fa fa-info-circle mx-2" aria-hidden="true"></i></h3> 
                  <div class="right">            
                  </div>
                </div> 
                <div class="inner has-list-table">
                  <div>
                    <div class="chart p-5" id="chart_spend_by_hour">
                      <div class="loading">
                          <div class="d-flex justify-content-center my-3 width100 pull-left">
                          <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </div> 
                         
                      </div>
                      <canvas id="chart-chart_spend_by_hour"></canvas>
                       
                       </div>
                     </div>
                   </div>
                     </div>
                   </div>
         </div> 
      </div>
  </div>
</div>
  