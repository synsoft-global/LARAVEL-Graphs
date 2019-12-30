 <div class="main-container rve-gph-grid order-rve-grid ">


        
        <div class="header clearfix weekheader">



          <div class="col-md-5 col-sm-4 col-xs-12 pull-left">
            
            <div class="title"><h2>
                                        Orders
                                     </h2> 

                                      <button data-toggle="popover"  data-trigger="hover" data-content="Export a csv of this chart's data" data-tippy-placement="top" data-placement="top" id="export_chart_data" class="btn btn-primary icon-left mb-2 ml-3 export-btn hide_media" type="button">
                                Export <span class="btn-icon ua-icon-download"></span>
                              </button>
                              <div class="filter-loading" style="display: none;">
                                 <div class="d-flex justify-content-center my-3 width100 pull-left">
                                      <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    </div> 
                                 </div>

                                  </div>

          </div>
          <div class="col-md-7 col-sm-8 col-xs-12 pull-left">
            
                  <div class="right">
                  <div>                    
                  <button id="breakdown_btn" class="btn btn-outline-primary mb-2 mr-3 pull-left breakdown-btn" type="button">Breakdown</button>



                  <div class="btn-group btn-collection btn-icon-group orders-four-btn-grp pull-right mobile-hide-btn-group">
                   <button id="hour_btn" type="button" class="btn btn-secondary" value="hour">
                    Hour
                    </button> 
                    <button id="day_btn" class="btn btn-secondary" type="button" value="day">Day</button>
                    <button id="week_btn" class="btn btn-secondary" type="button" value="week">Week</button>
                    <button id="month_btn" class="btn btn-secondary active" type="button" value="month">Month</button>
                  </div>




                  
                  </div>
                </div>

          </div>

               
          
      </div>
      <!--end header-->

      <div class="p-5">  
        <canvas id="chart-orders"></canvas>
      </div>
</div>