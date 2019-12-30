<div class="product-grp-container">
<div class="subnav-one text-right"> 
  <p class="mobile-text-left">  {{ __('messages.products.orders_created') }}</p>
</div>
<div class="subnav-two"> 
         <div class="dropdown dropdown-lg adv-filter-search-bar" data-toggle="popover" data-trigger="hover" data-content="{{ __('messages.products.Compare_to_previous_period') }}" data-tippy-placement="left" data-placement="left" >
          <button class="btn btn-secondary1 width100 header-compare-button" type="button" data-toggle="dropdown"> 
          
                      <span><span class="vs hidden-xs hidden-sm header-compare-typo">{{ __('messages.products.Compare_To') }}: </span> 
                      <span id="{{(isset($order_detail) && $order_detail) ? 'compare_date_datepicker_detail_html' : 'compare_date_html' }}" class="dates">
                       {{!empty(session('compare_range_picker'))?session('compare_range_picker'):''}}
                  </span></span>

            </button>
           <div class="dropdown-menu p-0" role="menu">
            <form class="form-horizontal segment-filter-opt groups-date-dropdown m-0" role="form">
                <!-- start new dropdown structure -->

               <div class="row tight-inner-gutter previous-defaults my-0">
                <div class="col-8 px-0">
                <p>{{ __('messages.products.Compare_data_to') }}:<i class="fa fa-info-circle mx-2" aria-hidden="true"></i></p>
                </div> 
                <div class="col-4 pull-right pl-0">
                <button id="{{(isset($order_detail) && $order_detail) ? 'clear_compare_detail' : 'clear_compare' }}"class="btn btn-danger_dummy clear-btn" type="button">
                  Clear
                </button>           
                 </div>
              </div>

              <div class="row tight-inner-gutter previous-defaults my-2">
                <div class="col-4">
                   <button data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previous Period" data-tippy-placement="top" id="{{(isset($order_detail) && $order_detail) ? 'date_comapare' : 'date_comapare_list' }}" value="period" class="btn btn-primary period-btn" type="button">
                        Period
                      </button>              
                </div> 
                <div class="col-8">
                  <div class="btn-group btn-collection btn-group-sm 123">

                      <button id="{{(isset($order_detail) && $order_detail) ? 'date_comapare' : 'date_comapare_list' }}" class="btn btn-secondary" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Previous Year" value="year" data-tippy-placement="top" type="button">
                        Year
                      </button>

                      <button id="{{(isset($order_detail) && $order_detail) ? 'date_comapare' : 'date_comapare_list' }}" class="btn btn-secondary" data-placement="top" data-toggle="popover" value="month" data-trigger="hover" data-content="Previous Month" data-tippy-placement="top" type="button">
                       Month
                      </button>

                      <button id="{{(isset($order_detail) && $order_detail) ? 'date_comapare' : 'date_comapare_list' }}" class="btn btn-secondary" data-placement="top" data-toggle="popover" value="week" data-trigger="hover" data-content="Previous Week" data-tippy-placement="top" type="button"> 
                        Week
                      </button>
                    </div>
                 
                </div>
            </div> 


              <!-- end new dropdown structure -->



            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-0">
                  <input data-resourceType="products"  id="{{(isset($order_detail) && $order_detail) ? 'compare_date_datepicker_detail' : 'compare_date' }}" type="text" class="form-control js-date-custom-ranges" aria-label="Text input with dropdown button" value="{{!empty(session('compare_range_picker'))?session('compare_range_picker'):''}}">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary compare_order_range_view_icon" type="button"><span class="btn-icon ua-icon-list"></span></button>      
                  </div>
                </div>
               
              </div>
            </div> 
     

            </form>       
         </div>
       </div>
</div>
<div class="subnav-three">  
     <div class="input-group mb-0">
      <input data-resourceType="products"  id="{{(isset($order_detail) && $order_detail) ? 'product_detail_range' : 'order_range' }}" type="text" class="form-control js-date-custom-ranges" aria-label="Text input with dropdown button" value="{{!empty(session('product_range_picker'))?session('product_range_picker'):''}}">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary order_range_view_icon" type="button"><span class="btn-icon ua-icon-list"></span></button>      
      </div>
    </div>
</div>


</div>