<div class="row">
  <div class="col-12">
    <div class="main-container rve-gph-grid order-rve-grid">        
      <div class="header clearfix Ordersgroupedby-header">
        <div class="col-md-8 col-sm-12 col-xs-12 pull-left">  
        <?php 
          $selectedFilter = (!empty(session('groupbyValOrder')) ?session('groupbyValOrder'):'payment_method'); 
          $selected = explode("_",$selectedFilter)[0].'_country';             
        ?>           
          <div class="title"><h2 class="mr-3">Orders grouped by</h2> 
            <div class="btn-group btn-collection mr-3 mobile-hide-btn-group">
              <div class="">
                <span class="">
                  <div class="dataset__header-controls btn-group " id="aBtnGroup"> 
                    <button  type="button" class="groupby_order_detail btn btn-outline-secondary button  {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'payment_method_id')?'active' :''}}" value="payment_method_id" id="payment_method_id">
                      Payment Method ID
                    </button>       
                    <button  type="button" class="groupby_order_detail btn btn-outline-secondary button {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'payment_method_title')?'active' :''}}" value="payment_method_title" >
                      Payment Method Title
                    </button>                               
                  </div>
                </span>
              </div>       
            </div>

             </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 pull-left pr-0">            
          <div class="right">
            <div> 
              <div class="filter-loading" id="payment-filter-loading" style="display: none;">
                <div class="d-flex justify-content-center my-3 width100 pull-left">
                   <div class="spinner-border" role="status">
                     <span class="sr-only">Loading...</span>
                   </div>
                 </div> 
              </div>                   
              <button data-toggle="popover" data-trigger="hover" data-content="Export a csv of this data" data-tippy-placement="top" data-placement="top" class="btn btn-primary export_payment_btn pull-right hide_media" type="button">
                <i class="fa fa-download mr-1" aria-hidden="true"></i> Export 
              </button>
            </div>
          </div>
        </div> 
      </div>
      <!--end header-->


      <div class="main-container table-container orderby-revenue-grid">
         <div class="m-datatable">
        <table class="table table-striped  table-hover dataTable custom-datatable">
          <thead>
            <tr>
              <th>
                @if(session('groupbyValOrder') && session('groupbyValOrder') == 'payment_method_title')
                  Payment Method Title                  
                @else
                  Payment Method ID
                @endif
              
              </th>
              <th data-id="order_count" class="sorting  report_payment_sort {{check_active_case('report_payment_sort','order_count')}}">Orders
               
              </th>
              <th data-id="net_sales" class="sorting  report_payment_sort {{check_active_case('report_payment_sort','net_sales')}}">Net Sales
                
              </th>
              <th data-id="average_net" class="sorting  report_payment_sort {{check_active_case('report_payment_sort','average_net')}}">Average Net
              
              </th>
              <th data-id="gross_sales" class="sorting  report_payment_sort {{check_active_case('report_payment_sort','gross_sales')}}">Gross Sales
               
              </th>
              <th data-id="avg_gross_sales" class="sorting report_payment_sort {{check_active_case('report_payment_sort','avg_gross_sales')}}">Average Gross
               
              </th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($grouped_order_data) && count($grouped_order_data) > 0)
              @foreach($grouped_order_data as $k => $v)
              @if(isset($v["status_compare"]))
              <tr>
                  <td>
                    {{session('groupbyValOrder') && session('groupbyValOrder') == 'payment_method_id'?
                    (!empty($v['payment_method_id'])?ucfirst($v['payment_method_id']):'Other')
                    :(!empty($v['payment_method_title'])?ucfirst($v['payment_method_title']):'Other')}}                  
                  </td>
                  <td>
                    <div>
                        <a href="javascript:void(0)" class="link-info view-order-detail" data-selectedFilter="{{$selectedFilter}}" data-selectedValue="{{$v[$selectedFilter]}}" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="View matching orders" data-tippy-placement="right">
                        <strong>
                          {{$v['order_count']}}
                        </strong>
                      </a>
                      @if(isset($v['order_count_compare_percent']))
                      <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> 
                              <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously {{isset($v['order_count_compare'])?$v['order_count_compare']:'0'}}"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['order_count_compare_percent'])</span> 
                            </span>
                          </span>
                        </span>
                      </span> 
                      @endif
                    </div>
                  </td>
                  <td>
                    @money1($v['net_sales']) 
                    @if(isset($v['net_sales_compare_percent']))
                    <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> 
                              <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money(isset($v['net_sales_compare'])?$v['net_sales_compare']:'0')"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['net_sales_compare_percent'])</span>
                            </span>
                          </span>
                        </span>
                      </span> 
                    @endif
                  </td>
                  <td>
                    @money1($v['average_net']) 
                     @if(isset($v['average_net_compare_percent']))
                     <span class="growth">
                        <span>
                          <span class="infinite">
                            <span> 
                              <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['average_net_compare'])?$v['average_net_compare']:'0')"  data-tippy-placement="right" data-original-title="" title="">
                                @perchanges_avg1($v['average_net_compare_percent'])
                              </span>
                            </span>
                          </span>
                        </span>
                      </span> 
                    @endif
                  </td>
                  <td>
                    @money1($v['gross_sales']) 
                    @if(isset($v['gross_sales_compare_percent']))
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span> 
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['gross_sales_compare'])?$v['gross_sales_compare']:'0')"  data-tippy-placement="right" data-original-title="" title="">
                              @perchanges_avg1($v['gross_sales_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                    @endif
                  </td>
                  <td>
                    @money1($v['avg_gross_sales']) 
                    @if(isset($v['avg_gross_sales_compare_percent']))
                    <span class="growth">
                      <span>
                        <span class="infinite">
                          <span> 
                            <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['avg_gross_sales_compare'])?$v['avg_gross_sales_compare']:'0')"  data-tippy-placement="right" data-original-title="" title="">
                              @perchanges_avg1($v['avg_gross_sales_compare_percent'])
                            </span>
                          </span>
                        </span>
                      </span>
                    </span>
                    @endif
                  </td>
                </tr>
                @endif
              @endforeach
              @else
              <tr>
                <td colspan="6" class="text-center">No Data</td>
              </tr>
            @endif
          </tbody>
        </table></div>
      </div>
    </div>
  </div>
</div>



    