 <div class="col-12 pull-left p-0">                            
     <div class="header clearfix">
              <h3 class="mt-0">New vs. Returning Customers</h3> 
     </div>
    <!--end header-->
  </div>        
                 
  <div class="main-container table-container">
     <div class="m-datatable">
        <table class="table table-responsive table-stripped">
          <thead>
          <tr>
            <th>Type</th>
            <th>Customers</th>
            <th>Orders</th>
             <th>Net Sales</th>
            <th>Average Net</th>
            <th>Gross Sales</th>
            <th>Average Gross</th>
          </tr>
          </thead>
          <tbody>
             @if(!empty($order_data) && count($order_data) > 0)
              @foreach($order_data as $k => $v)
            <tr>
             <td><strong>{{ucfirst($k)}}</strong></td>
              <td> {{isset($v['customer_count'])?$v['customer_count']:0}} <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously {{isset($v['customer_count_c'])?$v['customer_count_c']:'0'}}" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['customer_count_p'])</span> </span>
                          </span>
                        </span>
                      </span>  </td>
              <td> {{isset($v['order_count'])?$v['order_count']:0}} 
                <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously {{isset($v['order_count_c'])?$v['order_count_c']:'0'}}" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['order_count_p'])</span> </span>
                          </span>
                        </span>
                      </span>  </td>
              <td>@money1($v['net_sales']) 
                <span class="growth">
                  <span>
                    <span class="infinite">
                      <span>
                        <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['net_sales_c'])?$v['net_sales_c']:'0')" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['net_sales_p'])
                        </span>
                      </span>
                    </span>
                  </span>
                </span>
              </td>
              <td>@money1($v['average_net']) 
                   </td>
              <td>@money1($v['gross_sales']) 
                <span class="growth">
                  <span>
                    <span class="infinite">
                      <span>
                        <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['gross_sales_c'])?$v['gross_sales_c']:'0')" data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['gross_sales_p'])
                        </span>
                      </span>
                    </span>
                  </span>
                </span>
              </td>
              <td>@money1($v['avg_gross_sales']) 
                   </td>
            </tr>
             @endforeach
             @else
                  <tr>
                    <td colspan="7" class="text-center">
                      <p>{{ __('messages.common.no_results') }}</p>        
                    </td>
                  </tr>
              @endif          
          </tbody>
        </table></div>
    </div>