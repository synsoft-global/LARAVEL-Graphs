<div class="main-container rve-gph-grid order-rve-grid">  
  <div class="header clearfix Ordersgroupedby-header">
    <div class="col-md-8 col-sm-12 col-xs-12 pull-left">            
      <div class="title"><h2 class="mr-3">Orders grouped by</h2> 
        <!-- <div class="btn-group btn-collection mr-3 mobile-hide-btn-group">
          <button class="btn btn-secondary" type="button">Shipping Country</button>
          <button class="btn btn-secondary" type="button">Shipping State</button> 
          <button class="btn btn-secondary" type="button">Shipping Country</button>
          <button class="btn btn-secondary" type="button">Shipping Zip</button>              
        </div> -->
        <?php 
              $selectedFilter = (!empty(session('groupbyValOrder')) ?session('groupbyValOrder'):'shipping_country'); 
              $selected = explode("_",$selectedFilter)[0].'_country';               
            ?> 
            <div class="">
              <span class="">
                <div class="dataset__header-controls btn-group" id="aBtnGroup"> 
                  <button  type="button" class="groupby_shipping btn btn-outline-secondary button  {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'shipping_country')?'active' :''}}" value="shipping_country" id="groupby_billing">
                    Shipping Country
                  </button>       
                  <button  type="button" class="groupby_shipping btn btn-outline-secondary button {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'shipping_state')?'active' :''}}" value="shipping_state" >
                    Shipping State
                  </button>   
                  <button  type="button" class="groupby_shipping btn btn-outline-secondary button {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'shipping_city')?'active' :''}}" value="shipping_city">
                    Shipping City
                  </button> 
                  <button  type="button" class="groupby_shipping btn btn-outline-secondary button {{!empty(session('groupbyValOrder') && session('groupbyValOrder') == 'shipping_zip')?'active' :''}}" value="shipping_zip">
                    Shipping Zip
                  </button>             
                </div>
              </span>
            </div>

      </div>
    </div>
    
<!-- correct -->
      <div class="col-md-4 form-group pull-left pdt-select pdt-country-select media-full-width" >
      <div class="right pull-right">
        <div>    
          <div class="filter-loading" id="shipping-filter-loading" style="display: none;">
            <div class="d-flex justify-content-center my-3 width100 pull-left">
               <div class="spinner-border" role="status">
                 <span class="sr-only">Loading...</span>
               </div>
             </div> 
          </div> 
           <button data-toggle="popover" data-trigger="hover" data-content="Export a csv of this data" data-tippy-placement="top" data-placement="top" class="btn btn-primary export_shipping_btn pull-right hide_media" type="button">
            <i class="fa fa-download mr-1" aria-hidden="true"></i> {{__('messages.customer_reports.Export')}}  
          </button>
            
        </div>
      </div>
      @if(isset($order_country))
        <div class="left pull-right country-dropdw-export" style="{{!empty(session('groupbyValOrder') && session('groupbyValOrder') != 'shipping_country')?'display: block;' :'display: none;'}}">
          <select class="form-control select_custom select2-hidden-accessible" data-placeholder="All countries..." id="groupby_shipping_where" tabindex="-1" aria-hidden="true">
            <option value="''">{{__('messages.customer_reports.All countries')}}</option>
            @foreach($order_country as $k=> $v)
              @if($v->$selected != 'Other')
              <option value="{{$v->$selected}}" {{!empty(session('whereValOrder') && session('whereValOrder') == $v->$selected)?'selected':''}}>{{get_country_name($v->$selected)}}</option>
              @endif
            @endforeach
                              <!-- <option value="Test" >Test</option> -->
          </select>
        </div>
      @endif
    </div>




    
    <!--<div class="col-md-2 col-sm-12 col-xs-12 pull-right pr-0">            
      <div class="right">
        <div>
          <div class="filter-loading" id="shipping-filter-loading" style="display: none;">
            <div class="d-flex justify-content-center my-3 width100 pull-left">
               <div class="spinner-border" role="status">
                 <span class="sr-only">Loading...</span>
               </div>
             </div> 
          </div>                    
          <button class="btn btn-primary export_shipping_btn pull-right" type="button">
            <i class="fa fa-download mr-1" aria-hidden="true"></i> Export 
          </button>
            
        </div>
      </div>
    </div> -->



  </div>
  <!--end header-->
  <div class="m-datatable">
    <table id="filter_datatable" class="table table-striped table-responsive mt-0 dataTable custom-datatable">
      <thead>
        <tr>
          <th>{{!empty(session('groupbyValOrder')) ? implode(' ', array_map('ucfirst', explode('_', session('groupbyValOrder')))):'Shipping Country'}}</th>

          <th data-id="order_count" class="sorting  report_shipping_sort {{check_active_case('report_shipping_sort','order_count')}}">Orders
              
              </th>
              <th data-id="net_sales" class="sorting  report_shipping_sort {{check_active_case('report_shipping_sort','net_sales')}}">Net Sales
                
              </th>
              <th data-id="average_net" class="sorting  report_shipping_sort {{check_active_case('report_shipping_sort','average_net')}}">Average Net
                
              </th>
              <th data-id="gross_sales" class="sorting  report_shipping_sort {{check_active_case('report_shipping_sort','gross_sales')}}">Gross Sales
              
              </th>
              <th data-id="avg_gross_sales" class="sorting  report_shipping_sort {{check_active_case('report_shipping_sort','avg_gross_sales')}}">Average Gross
              
              </th>
        
        </tr>
      </thead>
      <tbody>
        @if(!empty($grouped_order_data) && count($grouped_order_data) > 0)
          @foreach($grouped_order_data as $k => $v)
            @if(in_array("status_compare", $v))
            <tr>
              <td>
                <strong>
                  @if(session('groupbyValOrder')=='shipping_country')

                    {{empty($v[session('groupbyValOrder')]) || $v[session('groupbyValOrder')] == 'Unknown'?'Other': get_country_name($v[session('groupbyValOrder')])}}
                  
                  @else
                    {{!empty($v[session('groupbyValOrder')])? ucfirst($v[session('groupbyValOrder')]) : 'Other'}}
                  @endif
                </strong>
              </td>
              <td>
                <div>
                  <a href="javascript:void(0)" class="link-info view-order-detail" data-selectedFilter="{{$selectedFilter}}" data-selectedValue="{{$v[$selectedFilter]}}" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="View matching orders" data-tippy-placement="right">
                        <strong>
                          {{$v['order_count']}}
                        </strong>
                      </a> 
                  <span class="growth">
                    <span>
                      <span class="infinite">
                        <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously {{isset($v['order_count_compare'])?$v['order_count_compare']:'0'}}"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['order_count_compare_percent'])</span> </span>
                      </span>
                    </span>
                  </span> 
                </div>
              </td>
              <td>
                <div>
                  <span class="amount">
                    @money1($v['net_sales'])   
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite">
                        <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1($v['net_sales_compare'])"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['net_sales_compare_percent'])</span> </span>
                      </span>
                    </span>
                  </span> 
                </div>
              </td>
              <td>
                <div>
                  <span class="amount">
                    @money1($v['average_net'])  
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite">
                        <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['average_net_compare'])?$v['average_net_compare']:0)"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['average_net_compare_percent'])</span> </span>
                      </span>
                    </span>
                  </span> 
                </div>
              </td>
              <td>
                <div>
                  <span class="amount">
                    @money1($v['gross_sales'])   
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite">
                        <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['gross_sales_compare'])?$v['gross_sales_compare']:0)"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['gross_sales_compare_percent'])</span> </span>
                      </span>
                    </span>
                  </span> 
                </div>
               
              </td>
              <td>
                <div>
                  <span class="amount">
                    @money1($v['avg_gross_sales']) 
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite">
                        <span> <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previously @money1(isset($v['avg_gross_sales_compare'])?$v['avg_gross_sales_compare']:0)"  data-tippy-placement="right" data-original-title="" title="">@perchanges_avg1($v['avg_gross_sales_compare_percent'])</span> </span>
                      </span>
                    </span>
                  </span> 
                </div>
              </td>
            </tr>
            @endif
          @endforeach
            @if(session('showAllShipping') && session('showAllShipping')=='true')
            <tr id="show_all_button" class="show_row">
              <td  colspan="6"><button id="shipping_show_all" class="btn btn-outline-primary icon-left" type="button">{{__('messages.reports.show_all_result')}}<span class="btn-icon ua-icon-download"></span></button></td>
            </tr>
            @endif
        @else
            <tr>
              <td colspan="6" class="text-center">
                <p>{{ __('messages.common.no_results') }}</p>        
              </td>
            </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>