<div class="main-container simple-chart">
            <div class="summary">
              <div class="date">
                In this period

                <a class="gross avg_net" id="show_avg_gross"><span>See Gross Stats</span></a>
                <a class="gross avg_gross" id="show_avg_net" style="display: none;"><span>Hide Gross Stats</span></a>
              </div>

            <!--start to repeat-->
              <div class="kpi small first">
                <strong>
                  <span class= "amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="@money1($net_sales)" data-tippy-placement="right" data-original-title="" title="">
                    @money_decimal1($net_sales)
                  </span>                 
                  <span class="growth" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @money12($net_sales_compare)" data-tippy-placement="right" data-original-title="" title="">
                    <span>
                      <span class="infinite">
                        <span>  @perchanges_avg1($net_sales_compare_percent) </span>
                      </span>
                    </span>
                </span></strong> 
                <span class="about">Net Sales</span>
              </div>
              <!--end to repeat-->

                 <!--start to repeat-->
              <div class="kpi small first">
                <strong>
                  <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="@money1($gross_sales)" data-tippy-placement="right" data-original-title="" title="">
                    @money_decimal1($gross_sales)
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @money1($gross_sales_compare)" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($gross_sales_compare_percent) </span>
                      </span>
                    </span>
                </span></strong> 
                <span class="about">Gross Sales</span>
              </div>
              <!--end to repeat-->

                 <!--start to repeat-->
              <div class="kpi small first">
                <strong>
                  <!-- <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="{{$order_count}}" data-tippy-placement="right" data-original-title="" title="">  -->
                  <span class="amount">
                    {{$order_count}}
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously {{($order_count_compare)}}" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($order_count_compare_percent)  </span>
                      </span>
                    </span>
                </span></strong> 
                <span class="about">Orders</span>
              </div>
              <!--end to repeat-->
                    <!--start to repeat-->
              <div class="kpi small first">
                <strong>
                  <!-- <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="{{$item_count}}" data-tippy-placement="right" data-original-title="" title=""> -->
                    <span class="amount">
                    {{$item_count}}
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously {{$item_count_compare}}" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($item_count_compare_percent) </span>
                      </span>
                    </span>
                </span></strong> 
                <span class="about" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Gross items sold" data-tippy-placement="top" data-original-title="" title="">ITEMS</span>
              </div>
              <!--end to repeat-->
            <hr>
                   <!--start to repeat-->
              <div class="kpi small first avg_net">
                <strong>
                  <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="@money1($average_net)" data-tippy-placement="right" data-original-title="" title="">
                    @money_decimal1($average_net)
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @money1($average_net_compare)" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($average_net_compare_percent) </span>
                      </span>
                    </span>
                </span>
                 </strong> 
                <span class="about">Average Order Net</span>
              </div>
              <div class="kpi small first avg_gross" style="display: none;">
                <strong>
                  <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="@money1($avg_gross_sales)" data-tippy-placement="right" data-original-title="" title="">
                    @money_decimal1($avg_gross_sales)
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @money1($avg_gross_sales_compare)" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($avg_gross_sales_compare_percent) </span>
                      </span>
                    </span>
                </span>
                 </strong> 
                <span class="about">Average Order Gross</span>
              </div>
              <!--end to repeat-->
                     <!--start to repeat-->
              <div class="kpi small first">
                <strong>
                  <span class="amount" data-placement="top" data-toggle="popover" data-trigger="hover" data-content="@number_decimal_2($avg_item_count)" data-tippy-placement="right" data-original-title="" title="">
                    @number1($avg_item_count)
                  </span> 
                  <span class="growth">
                    <span>
                      <span class="infinite" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="Previously @number_decimal_2($avg_item_count_compare)" data-tippy-placement="right" data-original-title="" title="">
                        <span> @perchanges_avg1($avg_item_count_compare_percent) </span>
                      </span>
                    </span>
                </span>
                 </strong> 
                <span class="about">Average Order Items</span>
              </div>
              <!--end to repeat-->



            </div>
          </div>