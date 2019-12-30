<?php
/**
 * Description: Handle Reports-Order module functions.
 * Version: 1.0.0
 * Author: Synsoft Global
 * Author URI: https://www.synsoftglobal.com/
 *
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, session;
use Maatwebsite\Excel\Facades\Excel;
use Mail,Auth, Config;
use Carbon\Carbon;
use Mapper;
use Storage;
Use App\Helpers\ReportOrderHelper;
Use App\Model\Order;
Use App\Exports\ExportOrderReport;
use DateTime;

class ReportOrderController extends Controller
{
   

	 public function __construct(){
       
    }


    /**
     * Report orders list.
     *
     * @param Request $request     
     */     
    public function orders(Request $request){    
      try{
        return view('reports.orders');
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }

    /**
     * refunds list.
     *
     * @param Request $request     
     */     
    public function refunds(Request $request){      
      $data=array(); 
      return view('reports.refunds')->with($data);
    }

    /**
     * Customer list.
     *
     * @param Request $request     
     */     
    public function customers(Request $request){      
         $data=array(); 
      return view('reports.customers')->with($data);
    }


    /**
     * Report orders table group by value.
     *
     * @param Request $request     
     */     
    public function orders_payment(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }
      
        
        if(!empty($request->input('report_g_sort'))){
           session(['report_payment_sort' =>  $request->input('report_g_sort')]);     
        }else{
           session(['report_payment_sort' =>  '']);
        }
          
        if(!empty($request->input('orderbyValP'))){
           session(['orderbyValOrder' =>  $request->input('orderbyValP')]);     
        }else{
           session(['orderbyValOrder' =>  '']);
        }
        if(!empty($request->input('orderby'))){
           session(['orderbyOrder' =>  $request->input('orderby')]);     
        }else{
           session(['orderbyOrder' =>  '']);
        }
        if(!empty($request->input('groupbyVal'))){
           session(['groupbyValOrder' =>  $request->input('groupbyVal')]);  
           $groupBy = $request->input('groupbyVal');
        }else{
           session(['groupbyValOrder' =>  'payment_method_id']);
           $groupBy = 'payment_method_id';
        }
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 

        $order_grouped=ReportOrderHelper::get_orders_details_status($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare,$sub_groupBy='', $report_g_sort="");

        if($request->input('exportbtn') == 0){
          $payment_table = view("reports.ajax.orders.ajaxorderpaymenttable",$order_grouped[$groupBy])->render();   
          return response()->json(['payment_table'=> $payment_table]);
        }else{
          $name = 'grouped-by-'.$groupBy.'-data-'.time().'.csv';
          return Excel::download(new ExportOrderReport($order_grouped[$groupBy]['grouped_order_data'], $groupBy), $name);
        }    

        
      }catch(Exception $e){
        return redirect('/');
        die();
      }
    }


    /**
     * Report order's chart data.
     *
     * @param Request $request     
     */     
    public function orders_charts(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }

        if(!empty($request->input('chart_type'))){
            session(['chart_type' =>  $request->input('chart_type')]);
        }else{
           session(['chart_type' =>  'line']);
        }
      
        
        if(!empty($request->input('report_g_sort'))){
           session(['report_status_sort' =>  $request->input('report_g_sort')]);     
        }else{
           session(['report_status_sort' =>  '']);
        }
          
        if(!empty($request->input('orderbyValP'))){
           session(['orderbyValOrder' =>  $request->input('orderbyValP')]);     
        }else{
           session(['orderbyValOrder' =>  '']);
        }
        if(!empty($request->input('orderby'))){
           session(['orderbyOrder' =>  $request->input('orderby')]);     
        }else{
           session(['orderbyOrder' =>  '']);
        }
      
        if(!empty($request->input('groupbyVal'))){
           session(['groupbyValOrder' =>  $request->input('groupbyVal')]);  
           $groupBy = $request->input('groupbyVal');
        }else{
           session(['groupbyValOrder' =>  'status']);
           $groupBy = 'status';
        }

        $show_hours=false;
           $start = new DateTime($start_date);
           $end = new DateTime($end_date);

          $to = Carbon::createFromFormat('Y-m-d H:s:i', $start_date);
          $from = Carbon::createFromFormat('Y-m-d H:s:i', $end_date);
          $diff_in_months = $to->diffInMonths($from);
          $diff_in_days = $to->diffInDays($from);

         if($request->input('chartby')) {
            $chartby =$request->input('chartby');
         }else{   

          if($diff_in_days <= 1) {
            $chartby = "hour";    
            $show_hours=true;    
             
          } else if($diff_in_months <= 1) {
            $chartby = "day";      
             
          }else{
             $chartby = "month";
          }        
        } 

        if($diff_in_days <= 1) {                  
            $show_hours=true;
        } 
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 

    
        $chart_data=ReportOrderHelper::get_details_for_order_sales_chart($chartby, $start_date, $end_date, $start_date_compare, $end_date_compare,$diff_in_days);  
        

        if(!empty($request->input('export_chart'))){
          $data = json_decode($chart_data['chart']['chart'],true);
          $name = 'grouped-by-data-'.time().'.csv';
          return Excel::download(new ExportOrderReport($data,'date'), $name);
        }else{
          $chartSection = view("reports.ajax.orders.ajaxorderchart",$chart_data['chart'])->render();      
          $ordermonthly = view("reports.ajax.orders.ajaxordermonthly",array('monthly'=>$chart_data['monthly']))->render();      
          return response()->json(['chartSection'=> $chartSection,'ordermonthly'=>$ordermonthly,'data_chart'=>$chart_data['chart'],'show_hours'=>$show_hours]);
        }

      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }

    /**
     * Report order's status list.
     *
     * @param Request $request     
     */     
    public function orders_status(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }
      
        
        if(!empty($request->input('report_g_sort'))){
           session(['report_status_sort' =>  $request->input('report_g_sort')]);     
        }else{
           session(['report_status_sort' =>  '']);
        }
          
        if(!empty($request->input('orderbyValP'))){
           session(['orderbyValOrder' =>  $request->input('orderbyValP')]);     
        }else{
           session(['orderbyValOrder' =>  '']);
        }
        if(!empty($request->input('orderby'))){
           session(['orderbyOrder' =>  $request->input('orderby')]);     
        }else{
           session(['orderbyOrder' =>  '']);
        }
      
        if(!empty($request->input('groupbyVal'))){
           session(['groupbyValOrder' =>  $request->input('groupbyVal')]);  
           $groupBy = $request->input('groupbyVal');
        }else{
           session(['groupbyValOrder' =>  'status']);
           $groupBy = 'status';
        }
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 

        $order_grouped_status=ReportOrderHelper::get_orders_details_status($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare,$sub_groupBy='', $report_g_sort="");
        if($request->input('exportbtn') == 0){
          $status_table = view("reports.ajax.orders.ajaxorderstatustable",$order_grouped_status['status'])->render();          

          return response()->json(['status_table'=> $status_table]);
        }else{
          $name = 'grouped-by-'.$groupBy.'-data-'.time().'.csv';
          return Excel::download(new ExportOrderReport($order_grouped_status['status']['grouped_order_data'], $groupBy), $name);
        }
        
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }

    /**
     * Report order's status list.
     *
     * @param Request $request     
     */     
    public function orders_customer_type_detail(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }    
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 

        $order_data=ReportOrderHelper::get_orders_details_customers_type('', $start_date, $end_date, $start_date_compare, $end_date_compare,'', "");
         $html = view("reports.ajax.orders.ajaxordercustomertype",array('order_data'=>$order_data))->render();          

         return response()->json(['html'=> $html]);
        
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }


    /**
     * Report orders list of billing table.
     *
     * @param Request $request     
     */     
    public function orders_billing(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }

        if(!empty($request->input('showAll'))){
           session(['showAll' =>  $request->input('showAll')]);     
        }else{
           session(['showAll' =>  false]);
        }
      
        
        if(!empty($request->input('report_g_sort'))){
           session(['report_billing_sort' =>  $request->input('report_g_sort')]);     
        }else{
           session(['report_billing_sort' =>  '']);
        }
          
        if(!empty($request->input('orderbyValP'))){
           session(['orderbyValOrder' =>  $request->input('orderbyValP')]);     
        }else{
           session(['orderbyValOrder' =>  '']);
        }
        if(!empty($request->input('orderby'))){
           session(['orderbyOrder' =>  $request->input('orderby')]);     
        }else{
           session(['orderbyOrder' =>  '']);
        }
        if(!empty($request->input('whereVal')) && $request->input('whereVal')!=="''"){
           session(['whereValOrder' =>  $request->input('whereVal')]);     
        }else{
            session(['whereValOrder' =>  '']);     
        }

        if(!empty($request->input('groupbyVal'))){
           session(['groupbyValOrder' =>  $request->input('groupbyVal')]);  
           $groupBy = $request->input('groupbyVal');
        }else{
           session(['groupbyValOrder' =>  'billing_country']);
           $groupBy = 'billing_country';
        }
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 
        $showAll=session('showAll');
        $order_grouped_status=ReportOrderHelper::get_orders_details_status($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare,$sub_groupBy='', $report_g_sort="",$showAll);

        if($request->input('exportbtn') == 0){
          $data = $order_grouped_status[$groupBy];
          $data['order_country'] = $order_grouped_status['order_country'];
          $billing_table = view("reports.ajax.orders.ajaxordersbillingtable",$data)->render();          

          return response()->json(['billing_table'=> $billing_table]);
        }else{
          $name = 'grouped-by-'.$groupBy.'-data-'.time().'.csv';
          return Excel::download(new ExportOrderReport($order_grouped_status[$groupBy]['grouped_order_data'], $groupBy), $name);
        }  
        
        
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }
      /**
     * Report orders list of shipping table.
     *
     * @param Request $request     
     */     
    public function orders_shipping(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }

        if(!empty($request->input('showAll'))){
           session(['showAllShipping' =>  $request->input('showAll')]);     
        }else{
           session(['showAllShipping' =>  false]);
        }
      
        
        if(!empty($request->input('report_g_sort'))){
           session(['report_shipping_sort' =>  $request->input('report_g_sort')]);     
        }else{
           session(['report_shipping_sort' =>  '']);
        }
          
        if(!empty($request->input('orderbyValP'))){
           session(['orderbyValOrder' =>  $request->input('orderbyValP')]);     
        }else{
           session(['orderbyValOrder' =>  '']);
        }
        if(!empty($request->input('orderby'))){
           session(['orderbyOrder' =>  $request->input('orderby')]);     
        }else{
           session(['orderbyOrder' =>  '']);
        }
        if(!empty($request->input('whereVal')) && $request->input('whereVal')!=="''"){
           session(['whereValOrder' =>  $request->input('whereVal')]);     
        }else{
            session(['whereValOrder' =>  '']);     
        }

        if(!empty($request->input('groupbyVal'))){
           session(['groupbyValOrder' =>  $request->input('groupbyVal')]);  
           $groupBy = $request->input('groupbyVal');
        }else{
           session(['groupbyValOrder' =>  'shipping_country']);
           $groupBy = 'shipping_country';
        }
       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 
        $showAll=session('showAllShipping');
        $order_grouped_status=ReportOrderHelper::get_orders_details_status($groupBy, $start_date, $end_date, $start_date_compare, $end_date_compare,$sub_groupBy='', $report_g_sort="",$showAll);

        
        if($request->input('exportbtn') == 0){
          $data = $order_grouped_status[$groupBy];
          $data['order_country'] = $order_grouped_status['order_country'];
          $shipping_table = view("reports.ajax.orders.ajaxordershippingtable",$data)->render();          

          return response()->json(['shipping_table'=> $shipping_table]);

        }else{
          $name = 'grouped-by-'.$groupBy.'-data-'.time().'.csv';
          return Excel::download(new ExportOrderReport($order_grouped_status[$groupBy]['grouped_order_data'], $groupBy), $name);
        }  
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }



    

      /**
     * Report orders list of side widget.
     *
     * @param Request $request     
     */     
    public function orders_sidewidgets(Request $request){   

      $data=array(); 
      try{
        if(!empty($request->input('range_picker'))){
            session(['product_range_picker' =>  $request->input('range_picker')]);
        }

        if(!empty($request->input('compare_range_picker'))){
          session(['compare_range_picker' =>  $request->input('compare_range_picker')]);
        }else if(!empty($request->input('range_picker'))){
          session(['compare_range_picker' =>  session('range_picker')]);
        }

        global $start_date,$end_date;
        if (!empty(session('product_range_picker'))) {
          $date_exp = explode('-', session('product_range_picker'));
          $start_date=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";         
        }else{
          $date=session('store_start_date');
          $start_date=date('Y-m-d',strtotime($date))." 00:00:00";
          $end_date=date('Y-m-d');
          $start_date_f=date('m/d/Y',strtotime($date))." 23:59:59";
          $end_date_f=date('m/d/Y');
          session(['product_range_picker' =>  $start_date_f.' - '.$end_date_f]);           
        } 

        global $start_date_compare, $end_date_compare;

        if (!empty(session('compare_range_picker'))) {
          $date_exp = explode('-', session('compare_range_picker'));
          $start_date_compare=date('Y-m-d',strtotime($date_exp[0]))." 00:00:00";
          $end_date_compare=date('Y-m-d',strtotime($date_exp[1]))." 23:59:59";  
        }else{
          $date=session('store_start_date');
          $start_date_compare=date('Y-m-d',strtotime($date));
          $end_date_compare=date('Y-m-d');
          $start_date_compare_f=date('m/d/Y',strtotime($date))." 00:00:00";
          $end_date_compare_f=date('m/d/Y')." 23:59:59";
          session(['compare_range_picker' =>  $start_date_compare_f.' - '.$end_date_compare_f]);           
        }

       
        /*
        * get order details for tables grou by status, billing country, state, country, payment method.
        * @param product_id int, groupBy string
        */ 
        $grouped_order_data=ReportOrderHelper::get_details_of_total_order_report($start_date, $end_date, $start_date_compare, $end_date_compare);

        
        $item_count=ReportOrderHelper::get_details_of_sub_graph($start_date, $end_date, $start_date_compare, $end_date_compare,'item');
        
        $order_count=ReportOrderHelper::get_details_of_sub_graph($start_date, $end_date, $start_date_compare, $end_date_compare,'order');
       
        $spend_by_day=ReportOrderHelper::get_details_of_sub_graph($start_date, $end_date, $start_date_compare, $end_date_compare,'day');
        
        $spend_by_hour=ReportOrderHelper::get_details_of_sub_graph($start_date, $end_date, $start_date_compare, $end_date_compare,'hour');
                
        $sidewidget = view("reports.ajax.orders.ajaxorderssidewidgets",$grouped_order_data['order_data'][0])->render();          
        $widget = view("reports.ajax.orders.ajaxorderswidgets",$grouped_order_data['order_data'][0])->render();
        return response()->json(['sidewidget'=> $sidewidget, 'widget'=> $widget,'item_count'=>$item_count,'order_count'=>$order_count,'spend_by_day'=>$spend_by_day,'spend_by_hour'=>$spend_by_hour]);
      }catch(Exception $e){
        return redirect('/');
        die();
      }


    }

    



}
