<?php
/**
 * Description: Report Order helper for parse request data and insert related database.
 * Version: 1.0.0
 * Author: Synsoft Global
 * Author URI: https://www.synsoftglobal.com/
 *
 */
namespace App\Helpers;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Model\ProductMeta;
use App\Model\Product;
use App\Model\ProductGroup;
use App\Model\Category;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\RefundItem;
use Carbon\Carbon;
use DB, session;
use App\Segment\Products;
use App\Model\storeData;
use Carbon\CarbonPeriod;

class ReportOrderHelper
{


	/**
	 * Get details of chart data for order sales.
	 *
	 * @since 2.0.5
	 *
	 * @param $sort_by, $start_date, $end_date, $start_date_compare, $end_date_compare,$diff_in_days
	 * @return Array (All chart details)
	 */
	public static function get_details_for_order_sales_chart($sort_by, $start_date, $end_date, $start_date_compare, $end_date_compare,$diff_in_days){
		try{
			$start = new DateTime($start_date);
			$end = new DateTime($end_date);

			$start_compare = new DateTime($start_date_compare);
			$end_compare = new DateTime($end_date_compare);

			$to_c = Carbon::createFromFormat('Y-m-d H:s:i', $start_date_compare);
            $from_c= Carbon::createFromFormat('Y-m-d H:s:i', $end_date_compare);	  
	        $diff_in_days_c = $to_c->diffInDays($from_c);


			$data_by = ($sort_by) ? $sort_by : "month";

			// Query order items table for chart data
			$label = array();
			$result = array();

			// Query order table for labels in chart
			$sales_query = Order::query();

			$sales_query->select(
				'orders.date_created as date_created',
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_sales'), 
				DB::raw('IF(orders.id IS NULL, 0, COUNT(orders.id)) as order_count'), 
				DB::raw('IF(orders.order_item_count IS NULL, 0, SUM(orders.order_item_count)) as items_count'), 
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				//DB::raw('IF(orders.total_refund IS NULL, 0, SUM(orders.	total_refund)) as refunds'), 
				DB::raw('REPLACE((IF(orders.total_refund IS NULL, 0, SUM(orders.total_refund))), "-", "") as refunds'),
				DB::raw('IF(orders.total_tax IS NULL, 0, SUM(orders.total_tax)) as taxes'),
				DB::raw('IF(orders.shipping_total IS NULL, 0, SUM(orders.shipping_total)) as shipping'),
				DB::raw('IF(orders.total_fees IS NULL, 0, SUM(orders.total_fees)) as fees'),
				DB::raw('IF(orders.discount_total IS NULL, 0, SUM(orders.discount_total)) as discounts')
			);

			$sales_query->orderby('orders.date_created');

			$sales_query->whereNotIn('orders.status',array("cancelled", "failed", "pending"));

			

			$sales_query_compare = clone $sales_query;
			$sales_query_compare_list = clone $sales_query;

			$sales_query->whereBetween('orders.date_created',[$start_date, $end_date]);
			$sales_query_compare->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);
			$sales_query_compare_list->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);


			$sales_m['net_sales'] = $sales_query->sum('orders.final_total');


			$sales_m['net_sales_text'] = 'Net';
			$sales_m['gross_sales']  = $sales_query->sum('orders.total');
			$sales_m['gross_sales_text']  ='Gross';
			$sales_m['order_count']  = $sales_query->count('orders.id');
			$sales_m['order_count_text'] = 'Orders';
			$sales_m['items_count']  = $sales_query->sum('orders.order_item_count');
			$sales_m['items_count_text']  = 'Items';

			$sales_m['net_sales_c']  = $sales_query_compare->sum('orders.final_total');
			$sales_m['gross_sales_c']  = $sales_query_compare->sum('orders.total');
			$sales_m['order_count_c']  = $sales_query_compare->count('orders.id');
			$sales_m['items_count_c']  = $sales_query_compare->sum('orders.order_item_count');
			
			$results=ReportOrderHelper::get_chart_data_list($sales_query,$start_date,$end_date,$data_by);
			$results_p=ReportOrderHelper::get_chart_data_list($sales_query_compare_list,$start_date_compare,$end_date_compare,$data_by);

	
			$diff_in_days=$diff_in_days+1;
			$data_by_value=30;
			$data_by_text='Monthly';
		  	if($data_by == "week") {
		  		$data_by_value=7;	
		  		$data_by_text='Weekly';	    	

		    }else if($data_by == "day") {
		    	$data_by_value=1;
		    	$data_by_text='Daily';		    	

		    }else if($data_by == "hour") {
		    	$data_by_value=1;
		    	$diff_in_days=($diff_in_days*12);    		
		    	$diff_in_days_c=($diff_in_days*12);    
		    	$data_by_text='Hourly';
			 	    	
	     	}	

	     

		foreach (array('net_sales','gross_sales','order_count','items_count') as $key => $value) {
			if($sales_m[$value]!=0 && $diff_in_days!=0){
				$monthly[$value] = ($sales_m[$value]/$diff_in_days)*$data_by_value;
	  			$monthly[$value.'_c'] = ($sales_m[$value.'_c']/$diff_in_days_c)*$data_by_value;
  			}else{
  				$monthly[$value] = 0;
	  			$monthly[$value.'_c'] = 0;
  			}
  			if($monthly[$value.'_c'] == 0 || $monthly[$value]==0) {
	          $monthly[$value.'_p'] = 0;
	        }else{
	          $monthly[$value.'_p'] = round(( $monthly[$value] - $monthly[$value.'_c'] ) * 100 / $monthly[$value.'_c'],1);
	        } 
	        $monthly[$value.'_text']=$data_by_text.' '.$sales_m[$value.'_text'];
		}
	     	

  			
		
			$data['label'] = json_encode($results['label']);
			$data['chart'] = json_encode($results['result']);
			$data['chart_p'] = json_encode($results_p['result']);
			$data['unit'] = $data_by;
			$data['currency'] = get_currency_symbol(session('store_currency'));
			$final_data['chart'] = $data;
			$final_data['monthly'] = $monthly;
			return $final_data;
		}catch(Exception $e){
          return redirect('/');
          die();
      	}
	}

	/**
	 * Get chart data weekly, daily or monthly.
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $sales_query, $data_by
	 * @return Array (All chart details)
	 */
	public static function get_chart_data_list($sales_query,$start_date,$end_date,$data_by){

		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));

		$period = CarbonPeriod::create($start_date, $end_date);		
		$label = array();
		$dates=[];
		$result=[];

		foreach ($period as $date) {
		    if($data_by == "month") {
		    	 $dates[]=$date->format('Y-m');	    	
		    }else if($data_by == "week") {
		    	$dates[]=$date->format('Y-W');
		    }else if($data_by == "day") {
		    	$dates[]=$date->format('Y-m-d');
		    } else if($data_by == "hour") {
			  $dates_h[]=$date->format('Y-m-d');
			 if(count(array_unique($dates_h)) > 0 && count(array_unique($dates_h)) < 3){
			   foreach (array_unique($dates_h) as $key => $value) {
			     for($i=0;$i<=24;$i++){
			     	$val=$value.' '.$i;
			     	if($i<10){
			     		$val=$value.' 0'.$i;
			     	}
			     	$val=$val.':00';
			        $dates[]=$val;
			       	 if(!in_array($val, $label)){	
			       		array_push($label, $val);
			        }	
			     }
			   }
			 }			    	
	     }
		}


		$dates = array_unique($dates);
	

		if($data_by == "month") {
			$sales_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%m")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), month(`orders`.`date_created`)'));
			
		}else if($data_by == "week") {
			$sales_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%u")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), WEEKOFYEAR(`orders`.`date_created`)'));
			
		}else if($data_by == "day") {
			$sales_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%m"),"-",DATE_FORMAT(orders.date_created,"%d")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), month(`orders`.`date_created`), date(`orders`.`date_created`)'));
			
		}else if($data_by == "hour") {
		 	$sales_query->addSelect(DB::raw('CONCAT (YEAR(`orders`.`date_created`),"-",DATE_FORMAT(`orders`.`date_created`,"%m"),"-",DATE_FORMAT(`orders`.`date_created`,"%d")," ",hour(`orders`.`date_created`)) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), month(`orders`.`date_created`), date(`orders`.`date_created`), hour(`orders`.`date_created`)'));
		 
		 }

		 $sales = $sales_query->get()->toArray();


		foreach($dates as $k => $date){
			if($data_by == "week") {
				$date_1=str_replace("-", "W", $date);
				$date_1= date("Y-m-d", strtotime($date_1));
				if(!in_array($date_1, $label)){	
		       		array_push($label,$date_1);
		        }					
				
			}else{
				if(!in_array($date, $label)){	
		       		array_push($label, $date);
		        }
			}

			$count = 0;
			foreach($sales as $x => $sale){
				if($date == $sale['date']) {
					$count++;
					$sale["date"] = $date;
					$sale["previous_net_revenue"] = 0;				
					array_push($result, $sale); 
				}
			}

			if($count == 0) {
				array_push($result, [
					'date_created'=>$date,
					'date'=>$date,
					'net_sales'=>0, 
					'order_count'=>0, 
					'items_count'=>0, 							
					'gross_sales'=>0, 
					'refunds'=>0, 
					'taxes'=>0,
					'shipping'=>0,
					'previous_net_revenue'=>0,
					'fees'=>0,
					'discounts'=>0
				]);
			}
		}	

		return array('result'=>$result,'label'=>$label);

	}


	/**
	 * Get total of all the data in orders.
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $start_date_compare, $end_date_compare
	 * @return Array (All order details)
	 */
	public static function get_details_of_total_order_report($start_date, $end_date, $start_date_compare, $end_date_compare){
		DB::enableQueryLog();
		$order_query = Order::query()
			->select(
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_revenue'), 
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('IF(orders.total IS NULL, 0, AVG(orders.total)) as avg_gross_sales'), 
				DB::raw('REPLACE((IF(orders.total_refund IS NULL, 0, SUM(orders.total_refund))), "-", "") as refunds'),
				DB::raw('IF(orders.discount_total IS NULL, 0, SUM(orders.discount_total)) as discount_total'),  
				DB::raw('IF(orders.total_tax IS NULL, 0, SUM(orders.total_tax)) as taxes'),
				//DB::raw('IF(orders.order_item_count IS NULL, 0, SUM(orders.order_item_count))-IF(orders.total_refund_item_count IS NULL, 0, SUM(orders.total_refund_item_count)) as item_count'),  
				DB::raw('IF(orders.order_item_count IS NULL, 0, SUM(orders.order_item_count)) as item_count'),  
				DB::raw('IF(orders.order_item_count IS NULL, 0, AVG(orders.order_item_count)) as avg_item_count'),  
				//DB::raw('IF(orders.order_item_count IS NULL, 0, AVG(orders.order_item_count))-IF(orders.total_refund_item_count IS NULL, 0, AVG(orders.total_refund_item_count)) as avg_item_count'),
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_sales'),  
				DB::raw('IF(orders.final_total IS NULL, 0, AVG(orders.final_total)) as average_net'),
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'), 
				DB::raw('IF(orders.id IS NULL, 0, AVG(orders.id)) as avg_order_count'), 
				DB::raw('IF(orders.shipping_total IS NULL, 0, SUM(orders.shipping_total)) as shipping'),
				DB::raw('IF(orders.total_fees IS NULL, 0, SUM(orders.total_fees)) as fees')

			);
		 $order_query->whereNotIn('orders.status',array("cancelled", "failed", "pending"));
		$order_query_compare = clone $order_query;

		// sort the primary and comapred query by the start and end date sent
		$order_query->whereBetween('orders.date_created',[$start_date, $end_date]);
		$order_query_compare->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);

		$data['order_data'] = $order_query->get()->toArray();
		$data['order_data_compare'] = $order_query_compare->get()->toArray();

		//dd(DB::getQueryLog());

		// Calculation for percentage comparison between date range picker and compare range picker
		$compare_groupBy = "";
		foreach ($data['order_data'] as $k => $val) {
			if($data['order_data_compare'] && count($data['order_data_compare']) > 0) {		
				//echo '<pre>'; print_r($data); echo '</pre>';die;
				foreach ($data['order_data_compare'] as $z => $val_compare) {
					foreach ($val_compare as $j => $value) {
						$data['order_data'][$k][$j.'_compare'] = $value; 
						$data['order_data'][$k][$j.'_compare_percent']=comparePercentage($val[$j], $val_compare[$j]);
					}
				}
			}else{
				echo "else";
				foreach ($val as $j => $value) {
					$data['order_data'][$k][$j.'_compare'] = 0; 
					$data['order_data'][$k][$j.'_compare_percent']=0;
				}
			}
		}
		return $data;
	}


	/**
	 * Get total of all the data for graph.
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $start_date_compare, $end_date_compare,$type
	 * @return Array (All order details)
	 */
	public static function get_details_of_sub_graph($start_date, $end_date, $start_date_compare, $end_date_compare,$type){
		DB::enableQueryLog();
		$order_query = Order::query()
			->select(
				
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('order_item_count'),  		
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'),
				DB::raw('hour(date_created) as hour'),
				DB::raw('WEEKDAY(date_created) as day'),
				'date_created' 
				

			);
		 $order_query->whereNotIn('orders.status',array("cancelled", "failed", "pending"));
		

		// sort the primary and comapred query by the start and end date sent
		$order_query->whereBetween('orders.date_created',[$start_date, $end_date]);

		if($type=='item'){
			$order_query->groupBy('order_item_count')->orderBy('order_item_count','asc');
		}else if($type=='order'){
			$order_query_o = clone $order_query;
			//$order_query->groupBy('orders.total')->orderBy('orders.total','asc');
		}else if($type=='day'){		

			$order_query->groupBy(DB::raw('WEEKDAY(date_created)'));
		}else if($type=='hour'){			
			$order_query->groupBy(DB::raw('hour(date_created)'));
		}

	
		if($type=='order'){
			$result=[];
			$min=$order_query_o->min('orders.total');
			$max=$order_query_o->max('orders.total');	

			if($max>0 && $max<=100){
				$tick=(int)($max/5);
				for($i=0;$i<=10;$i++) {		
				
					$order_query_o = clone $order_query;		
					$start=($i)+(($i)*$tick);		
					$end=($i+1)+(($i+1)*$tick);

					$currency=get_currency_symbol(session('store_currency'));			
					$result[]=array('gross_sales'=>$start.'-'.$end,'order_count'=>$order_query_o->whereBetween('orders.total',[$start,$end])->count('orders.id'));
				}
			}else if($max>100){
				$tick=(int)($max/15);
				for($i=0;$i<=10;$i++) {						
					$order_query_o = clone $order_query;		
					$start=($i)+(($i)*$tick);		
					$end=($i+1)+(($i+1)*$tick);

					$currency=get_currency_symbol(session('store_currency'));			
					$result[]=array('gross_sales'=>$start.'-'.$end,'order_count'=>$order_query_o->whereBetween('orders.total',[$start,$end])->count('orders.id'));
				}
			}		
		}else{
				$result = $order_query->get()->toArray();
		}
	

		
		$label=[];
		$data['label'] = json_encode($label);
		$data['chart'] = json_encode($result);

		return $data;


		

		//dd(DB::getQueryLog());

		
		return $data;
	}




	/**
	 * Get total of all the data in orders group by value($groupBy).
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $start_date_compare, $end_date_compare
	 * @return Array (All order details)
	 */
	public static function get_orders_details_status($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare, $sub_groupBy, $report_g_sort='', $showAll=false){
		DB::enableQueryLog();
		$order_query = Order::query();
		$sub_group = explode('_', $groupBy)[0];

		if($sub_group == "billing" || $sub_group == "shipping") {
			$query_country = clone $order_query;
			$query_country->groupBy('orders.'.$sub_group.'_country');
			$data['order_country'] =  $query_country->get();

		}
			$order_query->select(
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('IF(orders.total IS NULL, 0, AVG(orders.total)) as avg_gross_sales'), 
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'), 
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_sales'),  
				DB::raw('IF(orders.final_total IS NULL, 0, AVG(orders.final_total)) as average_net'),
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'),
				'orders.status',
				DB::raw('REPLACE((IF(orders.total_refund IS NULL, 0, SUM(orders.total_refund))), "-", "") as refunds'),
				/*DB::raw('IF(orders.total_refund IS NULL, 0, SUM(orders.total_refund)) as refunds'), */
				DB::raw('IF(orders.total_tax IS NULL, 0, SUM(orders.total_tax)) as taxes'), 
				DB::raw('IF(orders.discount_total IS NULL, 0, SUM(orders.discount_total)) as discounts'), 
				DB::raw('IF(orders.shipping_total IS NULL, 0, SUM(orders.shipping_total)) as shipping'), 
				DB::raw('IF(orders.total_fees IS NULL, 0, SUM(orders.total_fees)) as fees'),

				DB::raw('(CASE WHEN `orders`.`payment_method_id` = ""  THEN "Other" WHEN `orders`.`payment_method_id` = NULL THEN "Other" ELSE `orders`.`payment_method_id` END) as payment_method_id'),

				DB::raw('(CASE WHEN `orders`.`payment_method_title` = ""  THEN "Other" WHEN `orders`.`payment_method_title` = NULL THEN "Other" ELSE `orders`.`payment_method_title` END) as payment_method_title'),
				/*'orders.payment_method',
				'orders.payment_method_title',*/
				DB::raw('(CASE WHEN `orders`.`billing_country` = ""  THEN "Other" WHEN `orders`.`billing_country` = NULL THEN "Other" ELSE `orders`.`billing_country` END) as billing_country'),
				DB::raw('(CASE WHEN `orders`.`billing_state` = ""  THEN "Other" WHEN `orders`.`billing_state` = NULL THEN "Other" ELSE `orders`.`billing_state` END) as billing_state'),
				DB::raw('(CASE WHEN `orders`.`billing_city` = ""  THEN "Other" WHEN `orders`.`billing_city` = NULL THEN "Other" ELSE `orders`.`billing_city` END) as billing_city'),
				DB::raw('(CASE WHEN `orders`.`billing_zip` = ""  THEN "Other" WHEN `orders`.`billing_zip` = NULL THEN "Other" ELSE `orders`.`billing_zip` END) as billing_zip'),
				DB::raw('(CASE WHEN `orders`.`shipping_country` = ""  THEN "Other" WHEN `orders`.`shipping_country` = NULL THEN "Other" ELSE `orders`.`shipping_country` END) as shipping_country'),
				DB::raw('(CASE WHEN `orders`.`shipping_state` = ""  THEN "Other" WHEN `orders`.`shipping_state` = NULL THEN "Other" ELSE `orders`.`shipping_state` END) as shipping_state'),
				DB::raw('(CASE WHEN `orders`.`shipping_city` = ""  THEN "Other" WHEN `orders`.`shipping_city` = NULL THEN "Other" ELSE `orders`.`shipping_city` END) as shipping_city'),
				DB::raw('(CASE WHEN `orders`.`shipping_zip` = ""  THEN "Other" WHEN `orders`.`shipping_zip` = NULL THEN "Other" ELSE `orders`.`shipping_zip` END) as shipping_zip')
				
			);
			

			if(session('orderbyValOrder')){
				$orderbyval  = session('orderbyValOrder');
			}else{
				$orderbyval  = 'order_count';

			} 
			if(session('orderbyOrder')){
				$orderby  = session('orderbyOrder');
			}else{
				$orderby  = 'desc';
			}
			if(session('groupbyValOrder')){
				$groupBy = session('groupbyValOrder');
			}else{
				$groupBy = $groupBy;
			}  

			//$data['countries'] =  get_countries();
			if($groupBy != 'status'){
				
			$order_query->whereNotIn('status',array("cancelled", "failed", "pending"));
			}
			if($sub_group == "billing" || $sub_group == "shipping") {				

				if(!empty(session('whereValOrder'))){
					$order_query->where('orders.'.$sub_group.'_country', '=', session('whereValOrder'));
				}
			}  
				
			$order_query_compare = clone $order_query;
        
		// sort the primary and comapred query by the start and end date sent
		$order_query->whereBetween('orders.date_created',[$start_date, $end_date]);
		$order_query_compare->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);
		$data['order_data_compare'] = $order_query_compare->groupby($groupBy)->orderby($orderbyval, $orderby)->get()->toArray();	
		$data[$groupBy]['grouped_order_data'] = $order_query->groupby($groupBy)->orderby($orderbyval, $orderby)->get()->toArray();	
		
		//dd(DB::getQueryLog());


		// Calculation for percentage comparison between date range picker and compare range picker
		$compare_groupBy = "";
		
		foreach ($data[$groupBy]['grouped_order_data'] as $k => $val) {
			
			if(!$showAll || $showAll=='false'){
				if($k>=6){
					if($sub_group == "shipping"){
						session(['showAllShipping' =>  true]);
					}
					if($sub_group == "billing"){
						session(['showAll' =>  true]);
					}
					break;
				}
			}else{
				if($sub_group == "shipping"){
					session(['showAllShipping' =>  false]);
				}
				if($sub_group == "billing"){
					session(['showAll' =>  false]);
				}					
			}
			if($data['order_data_compare'] && count($data['order_data_compare']) > 0) {		
				foreach ($data['order_data_compare'] as $z => $val_compare) {

					if($val_compare[$groupBy] == $val[$groupBy]){
						
						foreach ($val_compare as $j => $value) {

							$data[$groupBy]['grouped_order_data'][$k][$j.'_compare'] = $value; 
							$data[$groupBy]['grouped_order_data'][$k][$j.'_compare_percent']=comparePercentage($val[$j], $val_compare[$j]);
						}
					}

				}

				if(!in_array($val[$groupBy]."_compare", $data[$groupBy]['grouped_order_data'][$k])){
					foreach ($val as $j => $value) {
						$data[$groupBy]['grouped_order_data'][$k][$j.'_compare'] = 0; 
						$data[$groupBy]['grouped_order_data'][$k][$j.'_compare_percent']=0;
					}
				}

			}else{
				
				foreach ($val as $j => $value) {
					$data[$groupBy]['grouped_order_data'][$k][$j.'_compare'] = 0; 
					$data[$groupBy]['grouped_order_data'][$k][$j.'_compare_percent']=0;
				}
			}
		}

		return $data;
	}

	/**
	 * Get total of all the data in orders group by value($groupBy).
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $start_date_compare, $end_date_compare
	 * @return Array (All order details)
	 */
	public static function get_orders_details_customers_type($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare, $sub_groupBy, $report_g_sort='', $showAll=false){
		DB::enableQueryLog();
		$order_query = Order::query();		

		$order_query->select(
			DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
			DB::raw('IF(orders.total IS NULL, 0, AVG(orders.total)) as avg_gross_sales'), 
			DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'), 
			DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_sales'),  
			DB::raw('IF(orders.final_total IS NULL, 0, AVG(orders.final_total)) as average_net'),
			'customer_id'	
		);

		$order_query->whereNotIn('status',array("cancelled", "failed", "pending"));

		$column=DB::raw('count(customer_id)');	


		//select count(*) from orders GROUP by customer_id HAVING count(customer_id)>1	
		 
				
		$order_query_new = clone $order_query;
		$order_query_compare = clone $order_query;
		$order_query_compare_new = clone $order_query;
        
		// sort the primary and comapred query by the start and end date sent
		$order_query->whereBetween('orders.date_created',[$start_date, $end_date]);
		$order_query_new->whereBetween('orders.date_created',[$start_date, $end_date]);

		$order_query_compare->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);
		$order_query_compare_new->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);

		$order_query->groupby('customer_id')->havingRaw($column.' = 1');
		$order_query_compare->groupby('customer_id')->havingRaw($column.' = 1');

		$order_query_new->groupby('customer_id')->havingRaw($column.' > 1');	
		$order_query_compare_new->groupby('customer_id')->havingRaw($column.' > 1');		

		$data_q['new']['query'] = DB::table( DB::raw("({$order_query->toSql()}) as sub") )
            ->mergeBindings($order_query->getQuery()); 
		$data_q['new']['query_c'] = DB::table( DB::raw("({$order_query_compare->toSql()}) as sub") )
            ->mergeBindings($order_query_compare->getQuery()); 

		$data_q['returning']['query'] = DB::table( DB::raw("({$order_query_new->toSql()}) as sub") )
            ->mergeBindings($order_query_new->getQuery()); 
		$data_q['returning']['query_c'] = DB::table( DB::raw("({$order_query_compare_new->toSql()}) as sub") )
            ->mergeBindings($order_query_compare_new->getQuery()); 


       

		foreach (array('new','returning') as  $key) {
			$data[$key]['gross_sales']=$data_q[$key]['query']->sum('gross_sales');
			//dd(DB::getQueryLog());
			$data[$key]['gross_sales_c']=$data_q[$key]['query_c']->sum('gross_sales');

			$data[$key]['net_sales']=$data_q[$key]['query']->sum('net_sales');
			$data[$key]['net_sales_c']=$data_q[$key]['query_c']->sum('net_sales');

			$data[$key]['avg_gross_sales']=$data_q[$key]['query']->sum('avg_gross_sales');
			$data[$key]['average_net']=$data_q[$key]['query']->sum('average_net');

			$data[$key]['order_count']=$data_q[$key]['query']->sum('order_count');
			$data[$key]['order_count_c']=$data_q[$key]['query_c']->sum('order_count');

			$data[$key]['customer_count']=$data_q[$key]['query']->count('customer_id');
			$data[$key]['customer_count_c']=$data_q[$key]['query_c']->count('customer_id');

			$data[$key]['gross_sales_p']=comparePercentage($data[$key]['gross_sales'], $data[$key]['gross_sales_c']);
			$data[$key]['net_sales_p']=comparePercentage($data[$key]['net_sales'], $data[$key]['net_sales_c']);
			$data[$key]['order_count_p']=comparePercentage($data[$key]['order_count'], $data[$key]['order_count_c']);
			$data[$key]['customer_count_p']=comparePercentage($data[$key]['customer_count'], $data[$key]['customer_count_c']);


		}



		return $data;
	}



	/**
	 * Get chart detail for Order's report.
	 *
	 * @since 2.0.5
	 *
	 * @param $sort_by string, $start_date string, $end_date string
	 * @return Array (All chart details)
	 */
	public static function get_details_for_orders_sales_chart($sort_by, $start_date, $end_date, $start_date_compare, $end_date_compare){
		try{
			$start = new DateTime($start_date);
			$end = new DateTime($end_date);

			$start_compare = new DateTime($start_date_compare);
			$end_compare = new DateTime($end_date_compare);
			$data_by = ($sort_by) ? $sort_by : "month";

			// Query order items table for chart data
			$label = array();
			$result = array();

			// Query order table for labels in chart
			$order_query = Order::query()
			->select(
				'orders.date_created as date_created',
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_revenue'),  
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'), 
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('IF(orders.total_refund IS NULL, 0, SUM(orders.total_refund)) as refunds'), 
				DB::raw('IF(orders.total_tax IS NULL, 0, SUM(orders.total_tax)) as taxes'), 
				DB::raw('IF(orders.shipping_total IS NULL, 0, SUM(orders.shipping_total)) as shipping'), 
				DB::raw('IF(orders.total_fees IS NULL, 0, SUM(orders.total_fees)) as fees')
				/*DB::raw('IF(orders.final_total IS NULL, 0, AVG(orders.final_total)) as average_net'),
				DB::raw('IF(orders.order_item_count IS NULL, 0, SUM(orders.order_item_count)) as order_count'),
				'orders.status',
				'orders.payment_method',
				'orders.payment_method_title',
				'orders.billing_country',
				'orders.billing_state',
				'orders.billing_city',
				'orders.billing_zip',
				'orders.shipping_country',
				'orders.shipping_state',
				'orders.shipping_city',
				'orders.shipping_zip'*/
			);


			/*$sales_query = Order::query();

			$sales_query->select(
				'orders.date_created as date_created',
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total))+IF(refund_items.total IS NULL, 0, SUM(refund_items.total)) as net_revenue'), 
				DB::raw('IF(orders.id IS NULL, 0, COUNT(orders.id)) as order_count'), 
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('IF(refund_items.total IS NULL, 0, SUM(refund_items.total)) as refunds'), 
				DB::raw('IF(orders.total_tax IS NULL, 0, SUM(orders.total_tax)) as taxes'),
				DB::raw('IF(orders.shipping_total IS NULL, 0, SUM(orders.shipping_total)) as shipping'),
				DB::raw('IF(orders.total_fees IS NULL, 0, SUM(orders.total_fees)) as fees')
			);
			*/
			$start_date = date('Y-m-d', strtotime($start_date));
			$end_date = date('Y-m-d', strtotime($end_date));
			$period = CarbonPeriod::create($start_date, $end_date);
			$dates=[];
			foreach ($period as $date) {
			    if($data_by == "month") {
			    	 $dates[]=$date->format('Y-m');	    	
			    }else if($data_by == "week") {
			    	$dates[]=$date->format('Y-W');
			    }else if($data_by == "day") {
			    	$dates[]=$date->format('Y-m-d');
			    }
			 //    else if($data_by == "hour") {
				//  $dates_h[]=$date->format('Y-m-d');
				// if(count(array_unique($dates_h)) > 0 && count(array_unique($dates_h)) < 3){
				//   foreach (array_unique($dates_h) as $key => $value) {
				//     for($i=0;$i<24;$i++){
				//       $dates[]=$value.' '.$i;
				//       	 if(!in_array($value.' '.$i, $label)){	
				//        array_push($label, $value.' '.$i);
				//        }	
				//     }
				//   }
				// }			    	
			 //    }
			}

			$dates = array_unique($dates);
			if($data_by == "month") {
				$order_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%m")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), month(`orders`.`date_created`)'));
			}else if($data_by == "week") {
				$order_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%u")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), WEEKOFYEAR(`orders`.`date_created`)'));
			}else if($data_by == "day") {
				$order_query->addSelect(DB::raw('CONCAT (YEAR(orders.date_created),"-",DATE_FORMAT(orders.date_created,"%m"),"-",DATE_FORMAT(orders.date_created,"%d")) as date'))->groupBy(DB::raw('YEAR(`orders`.`date_created`), month(`orders`.`date_created`), date(`orders`.`date_created`)'));
			}

			/*$order_query
			->join("orders", function($join){   
            	$join->on("orders.id","=","orders.order_id");
            		// ->whereIn('status',['completed','processing','on-hold']);
 			 },'','','inner')
			->join('refund_items', function($join){
					$join
				->on('refund_items.product_id', '=','orders.product_id')               
				->on('refund_items.order_id','=', DB::raw('orders.order_id'));
				},'','','left')*/
			$order_query->orderby('orders.date_created');
			$sales = $order_query->get()->toArray();

			
			if(count($sales) > 0) {
				foreach($dates as $k => $date){
					if($data_by == "week") {
						$date_data = explode('-', $date);
						$timestamp = mktime( 0, 0, 0, 1, 1,  $date_data[0] ) + ($date_data[1] * 7 * 24 * 60 * 60 );
						// $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
						$timestamp_for_monday = strtotime('Last Monday',$timestamp);	
						$date_for_monday = date( 'Y-m-d', $timestamp_for_monday );
						array_push($label, $date_for_monday);
					}else{
						array_push($label, $date);
					}

					$count = 0;
					foreach($sales as $x => $sale){

						if($date == $sale['date']) {
							$count++;
							$sale["date"] = $date;
							$sale["previous_net_revenue"] = 0;
							array_push($result, $sale); 
						}
					}
					if($count == 0) {
						array_push($result, [
							'date_created'=>$date,
							'date'=>$date,
							'net_revenue'=>0, 
							'order_count'=>0, 
							'gross_sales'=>0, 
							'refunds'=>0, 
							'taxes'=>0,
							'shipping'=>0,
							'previous_net_revenue'=>0,
							'fees'=>0
						]);
					}
				}
			}

			if(isset($start_date_compare) && isset($end_date_compare)) {	

				$end_date_compare = date('Y-m-d', strtotime($end_date_compare));
				$period_compare = CarbonPeriod::create($start_date_compare, $end_date_compare);
				$dates_compare=[];
				$start_date_compare = date('Y-m-d', strtotime($start_date_compare));
				foreach ($period_compare as $date) {
				    if($data_by == "month") {
				    	$date_format = 'Y-m';
				    	$dates_compare[]=$date;	    
				    	// $dates_compare[]=$date->format('Y-m');	   
				    }else if($data_by == "week") {
				    	$date_format = 'Y-W';
				    	$dates_compare[]=$date;
				    	// $dates_compare[]=$date->format('Y-W');
				    }else if($data_by == "day") {
				    	$date_format = 'Y-m-d';
				    	$dates_compare[]=$date;
				    	// $dates_compare[]=$date->format('Y-m-d');
				    }
				}

				$difference = dateDiffInDays($start_date_compare,$start_date);
				$format = 'P'.$difference.'D';
				$interval = new DateInterval($format);
				foreach ($dates_compare as $date) {
				    $index='';
				    $prev_data='';
				    $manipulated_date = new DateTime($date);
				    $date_previous = $date;
				    $manipulated_date->add($interval);
				    $date_to_compare = $manipulated_date->format($date_format);
			    	foreach($result as $k => $val){
						if($result[$k]["date"] == $date_previous) {
							$prev_data = $val["net_revenue"];
						}

						if($result[$k]["date"] == $date_to_compare) {
							$index = $k;
						}
			    	} 

			    	if(isset($index) && isset($prev_data) && !empty($index) && !empty($prev_data) ) {
			    		$result[$index]["previous_net_revenue"] = $prev_data;
			    	}

				}
			}
		
			$data['label'] = json_encode($label);
			$data['chart'] = json_encode($result);
			$data['unit'] = $data_by;
			$data['currency'] = get_currency_symbol(session('store_currency'));
			$final_data['chart'] = $data;
			return $final_data;
		}catch(Exception $e){
          return redirect('/');
          die();
      	}
	}




		/**
	 * Get customers detail of all the data in orders for .
	 *
	 * @since 2.0.5
	 *
	 * @param $start_date, $end_date, $start_date_compare, $end_date_compare
	 * @return Array (All order details)
	 */
	public static function get_customer_orders_details($groupby, $start_date, $end_date, $start_date_compare, $end_date_compare){
		DB::enableQueryLog();
		$order_query = Order::query()
			->select(
				DB::raw('IF(orders.total IS NULL, 0, SUM(orders.total)) as gross_sales'), 
				DB::raw('IF(orders.total IS NULL, 0, AVG(orders.total)) as avg_gross_sales'), 
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'), 
				DB::raw('IF(orders.final_total IS NULL, 0, SUM(orders.final_total)) as net_sales'),  
				DB::raw('IF(orders.final_total IS NULL, 0, AVG(orders.final_total)) as average_net'),
				DB::raw('IF(orders.id IS NULL, 0, count(orders.id)) as order_count'),
				'orders.status',
				'orders.payment_method_id',
				'orders.payment_method_title',
				'orders.billing_country',
				'orders.billing_state',
				'orders.billing_city',
				'orders.billing_zip',
				'orders.shipping_country',
				'orders.shipping_state',
				'orders.shipping_city',
				'orders.shipping_zip',
				'orders.customer_id',
						DB::raw('(select Concat(customer_id) From orders Having count(*)=1) as c')
			);

			$order_query_compare = clone $order_query;

		// sort the primary and comapred query by the start and end date sent
		$order_query->whereBetween('orders.date_created',[$start_date, $end_date]);
		$order_query_compare->whereBetween('orders.date_created',[$start_date_compare, $end_date_compare]);

		$data['order_data_compare'] = $order_query_compare->orderby('order_count', 'desc')->get()->toArray();
		//dd(DB::getQueryLog());
		$data[$groupby]['grouped_order_data'] = $order_query->orderby('order_count', 'desc')->get()->toArray();


		//echo '<pre>'; print_r($data); echo '</pre>';die;
		// Calculation for percentage comparison between date range picker and compare range picker
		$compare_groupBy = "";
		$new_cust_count = 0;
		$return_cust_count = 0;
		foreach ($data[$groupby]['grouped_order_data'] as $k => $val) {
				//$data[$groupby]['grouped_order_data']
						if($val['order_count'] == 1){
							$data[$groupby]['grouped_order_data'][$k]['new_customer'] = $new_cust_count++;

						}else{
							$data[$groupby]['grouped_order_data'][$k]['return_customer'] = $return_cust_count++;
						}
			if($data['order_data_compare'] && count($data['order_data_compare']) > 0) {		
				foreach ($data['order_data_compare'] as $z => $val_compare) {

					if($val_compare[$groupby] == $val[$groupby]){
						foreach ($val_compare as $j => $value) {

							$data[$groupby]['grouped_order_data'][$k][$j.'_compare'] = $value; 
							$data[$groupby]['grouped_order_data'][$k][$j.'_compare_percent']=comparePercentage($val[$j], $val_compare[$j]);
						}
					}

				}

				if(!in_array($val[$groupby]."_compare", $data[$groupby]['grouped_order_data'][$k])){
					foreach ($val as $j => $value) {
						$data[$groupby]['grouped_order_data'][$k][$j.'_compare'] = 0; 
						$data[$groupby]['grouped_order_data'][$k][$j.'_compare_percent']=0;
					}
				}

			}else{
				
				foreach ($val as $j => $value) {
					$data[$groupby]['grouped_order_data'][$k][$j.'_compare'] = 0; 
					$data[$groupby]['grouped_order_data'][$k][$j.'_compare_percent']=0;
				}
			}
		}

		return $data;
	}
}