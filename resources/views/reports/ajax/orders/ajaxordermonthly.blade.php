 <div class="row">
      <div class="row average-period tight-inner-gutter">

      @foreach(array('net_sales','gross_sales','order_count','items_count') as $k => $value)
        @if($value == 'net_sales' || $value=='gross_sales')   
         <div class="col-sm-12 col-xs-12 col-md-6 col-lg-3">
          <div class="stats-box">
            <div class="clearfix">
              <div class="pull-left">
                <h2>@money_decimal1($monthly[$value])</h2> 
                <h4>{{$monthly[$value.'_text']}}</h4>
              </div> 
              <div class="pull-right">        
                <span class="growth">
                  <span>
                    <span class="infinite">
                      <span>   
                        <span class="growth growth-wrapper"  data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @money_decimal1($monthly[$value.'_c'])" data-tippy-placement="right">
                          @perchanges_avg1($monthly[$value.'_p'])                          
                        </span>
                      </span>
                    </span>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </div> 
        @else
         <div class="col-sm-12 col-xs-12 col-md-6 col-lg-3">
          <div class="stats-box">
            <div class="clearfix">
              <div class="pull-left">
                <h2>@number1($monthly[$value])</h2> 
                <h4>{{$monthly[$value.'_text']}}</h4>
              </div> 
              <div class="pull-right">        
                <span class="growth">
                  <span>
                    <span class="infinite">
                      <span>
                        <span class="growth growth-wrapper"  data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @number1($monthly[$value.'_c'])" data-tippy-placement="right">
                          @perchanges_avg1($monthly[$value.'_p'])                          
                        </span>
                      </span>
                    </span>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </div> 
        @endif

        

      @endforeach
  

       
       
        
        
      </div>

  </div>