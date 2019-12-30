<div class="row">
  <div class="col-12">
    <div class="main-container rve-gph-grid orderby-revenue-grid">
      <div class="col-12 pull-left p-0"> 
        <?php 
              $selectedFilter = (!empty(session('groupbyValOrder')) ?session('groupbyValOrder'):'status'); 
              $selected = explode("_",$selectedFilter)[0].'_country';               
            ?>                            
         <div class="header clearfix ">
                  <h3 class="">Orders grouped by <strong>Status</strong></h3> 
                  <div class="right">
                <div>                    
                  <div class="filter-loading" id="status-filter-loading" style="display: none;">
                    <div class="d-flex justify-content-center my-3 width100 pull-left">
                       <div class="spinner-border" role="status">
                         <span class="sr-only">Loading...</span>
                       </div>
                     </div> 
                  </div>
                  <button data-toggle="popover" data-trigger="hover" data-content="Export a csv of this data" data-tippy-placement="top" data-placement="top" class="btn btn-primary export_status_btn pull-right hide_media" type="button">
                   <i class="fa fa-download mr-1" aria-hidden="true"></i> Export 
                  </button>
                </div>
              </div>
         </div>
        <!--end header-->
      </div>

      <div class="main-container table-container">
         <div class="m-datatable">
        <table class="table table-responsive table-stripped dataTable custom-datatable" id="reportOrderTable">
          <thead>
            <tr>
              <th>Status</th>
              <th data-id="order_count" class="sorting  report_status_sort {{check_active_case('report_status_sort','order_count')}}">Orders
               
              </th>
              <th data-id="net_sales" class="sorting  report_status_sort {{check_active_case('report_status_sort','net_sales')}}">Net Sales
                
              </th>
              <th data-id="average_net" class="sorting  report_status_sort {{check_active_case('report_status_sort','average_net')}}">Average Net
              
              </th>
              <th data-id="gross_sales" class="sorting  report_status_sort {{check_active_case('report_status_sort','gross_sales')}}">Gross Sales
               
              </th>
              <th data-id="avg_gross_sales" class="sorting report_status_sort {{check_active_case('report_status_sort','avg_gross_sales')}}">Average Gross
               
              </th>
          
            </tr>
          </thead>
          <tbody>   
          <?php 

          ?>                
            @if(!empty($grouped_order_data))
              @foreach($grouped_order_data as $k => $v)
              <?php //echo "<pre>".in_array("status_compare", $v); die;?>
                @if(in_array("status_compare", $v))
                <tr>
                  <td>{{get_order_name($v['status'])}}</td>
                  <td>
                    <div>
                      <a href="javascript:void(0)" class="link-info view-order-detail" data-selectedFilter="{{$selectedFilter}}" data-selectedValue="{{$v[$selectedFilter]}}" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="View matching orders" data-tippy-placement="right">
                        <strong>
                          {{isset($v['order_count'])?$v['order_count']:0}}   
                        </strong>
                      </a> 
                      
                      <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously {{isset($v['order_count_compare'])?$v['order_count_compare']:'0'}}" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['order_count_compare_percent'])</span> </span>
                          </span>
                        </span>
                      </span> 
                    </div>
                  </td>
                  <td>@money1($v['net_sales']) 
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span>
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['net_sales_compare'])?$v['net_sales_compare']:'0')" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['net_sales_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                  </td>
                  <td>@money1($v['average_net']) 
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span>
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money(isset($v['average_net_compare'])?$v['average_net_compare']:'0')" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['average_net_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                  </td>
                  <td>@money1($v['gross_sales']) 
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span>
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['gross_sales_compare'])?$v['gross_sales_compare']:'0')" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['gross_sales_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                  </td>
                  <td>@money1($v['avg_gross_sales']) 
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span>
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['avg_gross_sales_compare'])?$v['avg_gross_sales_compare']:'0')"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['avg_gross_sales_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                  </td>
                </tr>
                @endif
              @endforeach
             @else
                  <tr>
                    <td colspan="6" class="text-center">
                      <p>{{ __('messages.common.no_results') }}</p>        
                    </td>
                  </tr>
              @endif
          </tbody>
        </table></div>
      </div>
    </div>
    <!-- end main-container-->
  </div>
</div>