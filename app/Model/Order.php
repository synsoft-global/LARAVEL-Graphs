<?php
/**
 * Description: Order helper for parse request data and insert related database.
 * Version: 1.0.0
 * Author: Synsoft Global
 * Author URI: https://www.synsoftglobal.com/
 *
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB, session, Auth;
Use App\Helpers\OrderHelper;
use App\Segment\Orders;
use App\Segment\Customers;

class Order extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function meta()
    {       
        return $this->hasMany('App\Model\OrderMeta');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_item()
    {       
        return $this->hasMany('App\Model\OrderItem');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_refund()
    {       
        return $this->hasMany('App\Model\Refund');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_note()
    {       
        return $this->hasMany('App\Model\OrderNote');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_coupon()
    {       
        return $this->hasMany('App\Model\OrderCoupon');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_fee_line()
    {       
        return $this->hasMany('App\Model\FeeLines');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_shipping_lines()
    {       
        return $this->hasMany('App\Model\OrderCoupon');
    }

     /**
     * Get the comments for the blog post.
     */
    public function order_tax_lines()
    {       
        return $this->hasMany('App\Model\OrderCoupon');
    }

      /**
     * Remove words from the start of a string.
     *
     * @param $text
     * @param int $count
     * @return string
     */
   public static function parse_order_data($data)
    {
       
         $content = array(
            'id' => $data->id,            
            'number' => $data->number,
            'parent_id' => $data->parent_id,
            'order_key' => $data->order_key,
            'created_via' => $data->created_via,
            'version' => $data->version,
            'status' => $data->status,
            'currency' => $data->currency,
            'date_created' => $data->date_created,
            'date_created_gmt' =>$data->date_created_gmt,
            'date_modified' => $data->date_modified,
            'date_modified_gmt' => $data->date_modified_gmt,
            'date_modified_gmt' => $data->date_modified_gmt,
            'discount_total' => $data->discount_total,                       
            'discount_tax' => $data->discount_tax,                       
            'shipping_total' => $data->shipping_total,                       
            'shipping_tax' => $data->shipping_tax,                       
            'cart_tax' => $data->cart_tax,                       
            'total' => $data->total,                       
            'total_tax' => $data->total_tax,                       
            'prices_include_tax' => $data->prices_include_tax,                       
            'customer_id' => $data->customer_id,              
                                   
            'customer_ip_address' => $data->customer_ip_address,                       
            'customer_user_agent' => $data->customer_user_agent,                       
            'customer_note' => $data->customer_note,                       
            'billing_first_name' => $data->billing->first_name,                       
            'billing_last_name' => $data->billing->last_name,                       
            'billing_company' => $data->billing->company,                       
            'billing_address_1' => $data->billing->address_1,                       
            'billing_address_2' => $data->billing->address_2,                       
            'billing_city' => $data->billing->city,                       
            'billing_state' => $data->billing->state,                       
            'billing_zip' => $data->billing->postcode,                       
            'billing_country' => $data->billing->country,                   
                                 
            'billing_email' => $data->billing->email,                       
            'billing_phone' => $data->billing->phone,                       
            'shipping_first_name' => $data->shipping->first_name,                       
            'shipping_last_name' => $data->shipping->last_name,                       
            'shipping_company' => $data->shipping->company,                       
            'shipping_address_1' => $data->shipping->address_1,                       
            'shipping_address_2' => $data->shipping->address_2,                       
            'shipping_city' => $data->shipping->city,                       
            'shipping_state' => $data->shipping->state,                       
            'shipping_zip' => $data->shipping->postcode,                       
            'shipping_country' => $data->shipping->country,                       
            'payment_method_id' => $data->payment_method,                       
            'payment_method_title' => $data->payment_method_title,
            'date_paid' => $data->date_paid,
            'date_paid_gmt' =>$data->date_paid_gmt,
            'date_completed' => $data->date_completed,
            'date_completed_gmt' => $data->date_completed_gmt,  
            'transaction_id' => $data->transaction_id  
           // 'set_paid' => $data->set_paid                  
                                  
                               
        );       
        return $content;
    }

     /**
     * Remove words from the start of a string.
     *
     * @param $text
     * @param int $count
     * @return string
     */
   public static function parse_customer_data($data)
    {
       
         $content = array(
            'date_created' => $data->date_created,
            'date_created_gmt' => $data->date_created_gmt,
            'date_modified' => $data->date_modified,
            'date_modified_gmt' => $data->date_modified_gmt,
            'email' => $data->billing->email,
            'first_name' => $data->billing->first_name,
            'last_name' => $data->billing->last_name,
            'role' =>'customer',            
            'username' => $data->billing->email,
            'billing_first_name' => $data->billing->first_name,
            'billing_last_name' => $data->billing->last_name,
            'billing_company' => $data->billing->company,
            'billing_address_1' => $data->billing->address_1,
            'billing_address_2' => $data->billing->address_2,
            'billing_city' => $data->billing->city,
            'billing_state' => $data->billing->state,
            'billing_zip' => $data->billing->postcode,
            'billing_country' => $data->billing->country,
            'billing_email' => $data->billing->email,
            'billing_phone' => $data->billing->phone,
            'shipping_first_name' => $data->shipping->first_name,
            'shipping_last_name' => $data->shipping->last_name,
            'shipping_company' => $data->shipping->company,
            'shipping_address_1' => $data->shipping->address_1,
            'shipping_address_2' => $data->shipping->address_2,
            'shipping_city' => $data->shipping->city,
            'shipping_zip' => $data->shipping->postcode,
            'shipping_state' => $data->shipping->state,
            'shipping_country' => $data->shipping->country,
            'is_paying_customer' => '',
            'orders_count' => '',
            'total_spent' =>'', 
            'avatar_url' =>'' ,        
            'customer_type' =>'guest'             
        );       
        return $content;
    }

     /**
     * Remove words from the start of a string.
     *
     * @param $text
     * @param int $count
     * @return string
     */
   public static function parse_customer_update_data($data)
    {
       
         $content = array(            
            'wp_id' => $data->customer_id,          
            'billing_first_name' => $data->billing->first_name,
            'billing_last_name' => $data->billing->last_name,
            'billing_company' => $data->billing->company,
            'billing_address_1' => $data->billing->address_1,
            'billing_address_2' => $data->billing->address_2,
            'billing_city' => $data->billing->city,
            'billing_state' => $data->billing->state,
            'billing_zip' => $data->billing->postcode,
            'billing_country' => $data->billing->country,
            'billing_email' => $data->billing->email,
            'billing_phone' => $data->billing->phone,
            'shipping_first_name' => $data->shipping->first_name,
            'shipping_last_name' => $data->shipping->last_name,
            'shipping_company' => $data->shipping->company,
            'shipping_address_1' => $data->shipping->address_1,
            'shipping_address_2' => $data->shipping->address_2,
            'shipping_city' => $data->shipping->city,
            'shipping_zip' => $data->shipping->postcode,
            'shipping_state' => $data->shipping->state,
            'shipping_country' => $data->shipping->country  
                       
        );       
        return $content;
    }

     /**
     * Remove words from the start of a string.
     *
     * @param $text
     * @param int $count
     * @return string
     */
   public static function parse_order_meta($data)
    {
        $meta_data=array();
        if(!empty($data->meta_data) && count($data->meta_data) > 0){
            foreach ($data->meta_data as $key => $value) {
              $meta_data[] = array('key'=>$value->key,'value'=>(!is_serialized($value->value )) ? maybe_serialize($value->value) : $value->value);
            }  
        }      
        return $meta_data;
    }


    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
    * Get searched, segment and orderby filtered data
    *
    *@param $request(Post data)
    *
    *@return Filtered data
    */
    public static function getalldata($request, $paginate=''){

        if(!empty($request->input('orderby'))){
            session(['orderbyOrder' =>  $request->input('orderby')]);          
        }else{
            session(['orderbyOrder' =>  'desc']); 
        }

        if(!empty($request->input('orderbyVal'))){                
            session(['orderbyValOrder' =>  $request->input('orderbyVal')]);               
        }else{
            session(['orderbyValOrder' =>  'orders.date_created_gmt']); 
        }


        if(!empty($request->input('whereVal'))){                           
            session(['whereValOrder' =>  $request->input('whereVal')]);
        }else{
            session(['whereValOrder' =>  '']);
        }
        
        if($request && !empty($request->input('limit'))){                           
            session(['limitOrder' =>  $request->input('limit')]);
        }

        $limit = !empty(session('limitOrder'))?session('limitOrder'):10;
        DB::enableQueryLog();

        $query = Order::query();
        $query->select('orders.id as order_id', 'orders.*', "customers.customer_type");
        $query->join('customers', 'customers.wp_id', '=', 'orders.customer_id','left');

        if (!empty(session('whereValOrder'))) {
            $query->when(session('whereValOrder'), function ($q) { 
              $q->where(function ($q) {    
                $q->where( DB::raw('concat(orders.billing_first_name," ",orders.billing_last_name)'), 'like', '%' . session('whereValOrder') . '%');           
                $q->orWhere('orders.billing_first_name', 'like', '%' . session('whereValOrder') . '%');
                $q->orWhere('orders.billing_last_name', 'like', '%' . session('whereValOrder') . '%');
                $q->orWhere('orders.billing_email', 'like', '%' . session('whereValOrder') . '%');
                $q->orWhere('orders.id', 'like', '%' . session('whereValOrder') . '%');
                return $q->orWhere('orders.billing_city', 'like', '%' . session('whereValOrder') . '%');
              });
            });
        } 

        
        if(!empty($request->input('segments'))){

            $query=OrderHelper::parse_order_segment($query,$request->input('segments'),$request->input('order_filter_type')); 
        } 

        $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $orders=new Orders();
         $orders->order_product_category(array('from'=>$cat),'in_list',$query,'','');  
         }

        $data['total']  = $query->count();
        $data['total_items'] =  $query->sum('orders.order_item_count');
       
        $data['total_orders'] =  $query->count('orders.id');
        $data['orders_gross_sale'] =  round($query->sum('orders.total'),1);
        $data['avg_order_items']=0;

        if(isset($data['total_orders']) && $data['total_orders'] > 0 && $data['total_items']>0){
            $data['avg_order_items'] =  round($data['total_items']/$data['total_orders'],1);
        }
        $data['avg_order_value']=0;

        if(isset($data['total_orders']) && $data['total_orders'] > 0 && $data['orders_gross_sale']>0){
            $data['avg_order_value'] =   round($data['orders_gross_sale']/$data['total_orders'],1);
        }    

        $query->orderBy(session('orderbyValOrder'), session('orderbyOrder'));

        $query->groupBy('orders.id');  

        
         DB::enableQueryLog();
        $data['filter_options']= OrderHelper::get_filters_dropdown();

        if($paginate == 1){

            $data['orders'] = $query->get();
        }else{
           
            $data['orders'] =$query->paginate($limit)->onEachSide(1);
        }
        //dd(DB::getQueryLog());
       
        $data['countries'] = get_countries();
        $data['orderby_html'] = OrderHelper::get_order_by_filter();
        return $data;
    }


    /**
    * Get searched, segment and orderby filtered data for export
    *
    *@param $request(Post data)
    *
    *@return Filtered data
    */
    public static function getExportData($postdata){

        
        DB::enableQueryLog();

        $query = Order::query();
        if($postdata['settings']['row_per_item'] == 0){
            $query->select(
                DB::raw('orders.id as order_id'),
                DB::raw('CONCAT("#", orders.number) as order_number'),
                DB::raw('orders.date_created_gmt as order_created_at'),
                DB::raw('orders.shipping_total as total_shipping'),
                DB::raw('orders.discount_total as total_discount'),
                DB::raw('orders.final_order_item_count as total_items'),
                DB::raw('REPLACE(orders.total_refund, "-", "") as total_refunds'),
                DB::raw('orders.billing_first_name as billing_address_first_name'),
                DB::raw('orders.billing_last_name as billing_address_last_name'),
                DB::raw('orders.billing_company as billing_address_company'),
                DB::raw('orders.billing_address_1 as billing_address_address_1'),
                DB::raw('orders.billing_address_2 as billing_address_address_2'),
                DB::raw('orders.billing_city as billing_address_city'),
                DB::raw('orders.billing_state as billing_address_state'),
                DB::raw('orders.billing_zip as billing_address_postcode'),
                DB::raw('orders.billing_country as billing_address_country'),
                DB::raw('orders.billing_email as billing_address_email'),
                DB::raw('orders.billing_phone as billing_address_phone'),
                DB::raw('orders.shipping_first_name as shipping_address_first_name'),
                DB::raw('orders.shipping_last_name as shipping_address_last_name'),
                DB::raw('orders.shipping_company as shipping_address_company'),
                DB::raw('orders.shipping_address_1 as shipping_address_address_1'),
                DB::raw('orders.shipping_address_2 as shipping_address_address_2'),
                DB::raw('orders.shipping_city as shipping_address_city'),
                DB::raw('orders.shipping_state as shipping_address_state'),
                DB::raw('orders.shipping_zip as shipping_address_postcode'),
                DB::raw('orders.shipping_country as shipping_address_country'),
                DB::raw('orders.date_modified_gmt as order_updated_at'),
                DB::raw('orders.date_completed_gmt as order_completed_at'),
                DB::raw('orders.date_paid_gmt as order_paid_at'),
                DB::raw('orders.customer_ip_address as customer_ip'),
                DB::raw('orders.*'),
                DB::raw("customers.customer_type"),
                DB::raw("customers.role as 'customer.role'"),
                DB::raw('group_concat(order_items.name SEPARATOR "\r\n") as lineItems')
        
            );
        }else{
            $query->select(
                DB::raw('orders.id as order_id'),
                DB::raw('CONCAT("#", orders.number) as order_number'),
                DB::raw('orders.date_created_gmt as order_created_at'),
                DB::raw('orders.shipping_total as total_shipping'),
                DB::raw('orders.discount_total as total_discount'),
                DB::raw('orders.final_order_item_count as total_items'),
                DB::raw('REPLACE(orders.total_refund, "-", "") as total_refunds'),
                DB::raw('orders.billing_first_name as billing_address_first_name'),
                DB::raw('orders.billing_last_name as billing_address_last_name'),
                DB::raw('orders.billing_company as billing_address_company'),
                DB::raw('orders.billing_address_1 as billing_address_address_1'),
                DB::raw('orders.billing_address_2 as billing_address_address_2'),
                DB::raw('orders.billing_city as billing_address_city'),
                DB::raw('orders.billing_state as billing_address_state'),
                DB::raw('orders.billing_zip as billing_address_postcode'),
                DB::raw('orders.billing_country as billing_address_country'),
                DB::raw('orders.billing_email as billing_address_email'),
                DB::raw('orders.billing_phone as billing_address_phone'),
                DB::raw('orders.shipping_first_name as shipping_address_first_name'),
                DB::raw('orders.shipping_last_name as shipping_address_last_name'),
                DB::raw('orders.shipping_company as shipping_address_company'),
                DB::raw('orders.shipping_address_1 as shipping_address_address_1'),
                DB::raw('orders.shipping_address_2 as shipping_address_address_2'),
                DB::raw('orders.shipping_city as shipping_address_city'),
                DB::raw('orders.shipping_state as shipping_address_state'),
                DB::raw('orders.shipping_zip as shipping_address_postcode'),
                DB::raw('orders.shipping_country as shipping_address_country'),
                DB::raw('orders.date_modified_gmt as order_updated_at'),
                DB::raw('orders.date_completed_gmt as order_completed_at'),
                DB::raw('orders.date_paid_gmt as order_paid_at'),
                DB::raw('orders.customer_ip_address as customer_ip'),
                DB::raw('order_items.total as item_total'),
                DB::raw('order_items.total_tax as item_total_tax'),
                DB::raw('orders.*'),
                DB::raw('order_items.product_id'),
                DB::raw('order_items.variation_id'),
                DB::raw('order_items.name'),
                DB::raw('order_items.sku'),
                DB::raw('order_items.quantity'),
                DB::raw('order_items.subtotal'),
                DB::raw('order_items.price'),
                DB::raw('order_items.subtotal_tax'),
                DB::raw('order_items.total as item_total'),
                DB::raw('order_items.total_tax as item_total_tax'),
                DB::raw("customers.customer_type"),
                DB::raw("customers.role as 'customer.role'")
            );
        }
        
        $query->join('customers', 'customers.wp_id', '=', 'orders.customer_id','left');
        if (!empty($postdata['whereVal'])) {
            $query->when($postdata['whereVal'], function ($q) use($postdata){
                $q->where( DB::raw('concat(orders.billing_first_name," ",orders.billing_last_name)'), 'like', '%' .$postdata['whereVal'] . '%');                   
                $q->orWhere('orders.billing_first_name', 'like', '%' . $postdata['whereVal'] . '%');
                $q->orWhere('orders.billing_last_name', 'like', '%' . $postdata['whereVal'] . '%');
                $q->orWhere('orders.billing_email', 'like', '%' . $postdata['whereVal'] . '%');
                $q->orWhere('orders.id', 'like', '%' . $postdata['whereVal'] . '%');
                return $q->orWhere('orders.billing_city', 'like', '%' . $postdata['whereVal'] . '%');
            });
        } 
        
        if(!empty($postdata['segments'])){

            $query=OrderHelper::parse_order_segment($query,$postdata['segments'],$postdata['filter_type']); 
        } 
        $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $orders=new Orders();
         $orders->order_product_category(array('from'=>$cat),'in_list',$query,'','');  
         }

        $data['orders']['total']  = $query->count();


        $data['orders']['total_items'] =  $query->sum('orders.order_item_count');
       
        $data['orders']['total_orders'] =  $query->count('orders.id');
        $data['orders']['orders_gross_sale'] =  round($query->sum('orders.total'),1);
        $query->join('order_items', 'order_items.order_id', '=', 'orders.id', 'left');

        $data['orders']['avg_order_items']=0;

        if(isset($data['orders']['total_orders']) && $data['orders']['total_orders'] > 0 && $data['orders']['total_items']>0){
            $data['orders']['avg_order_items'] =  round($data['orders']['total_items']/$data['orders']['total_orders'],1);
        }
        $data['orders']['avg_order_value']=0;

        if(isset($data['orders']['total_orders']) && $data['orders']['total_orders'] > 0 && $data['orders']['orders_gross_sale']>0){
            $data['orders']['avg_order_value'] =   round($data['orders']['orders_gross_sale']/$data['orders']['total_orders'],1);
        }  


        if(!empty($postdata['orderbyVal'])){
            $query->when(!empty($postdata['orderbyVal']), function ($q) use ($postdata){
                return $q->orderBy($postdata['orderbyVal'], $postdata['orderby']);
            });
        }else{
            $query->when(!empty($postdata['orderbyVal']), function ($q) {
                return $q->orderBy('orders.date_created_gmt', 'asc');
             });
        }  
        if($postdata['settings']['row_per_item'] == 0){
            $query->groupBy('orders.id');  
        }
        $postdata['settings']['cat']=$cat;
        $postdata['settings']['current_role']=$current_role;
        $data['orders']['orders'] = $query->get();
        $data['orders']['settings'] = $postdata['settings'];
        return $data;
    }


    public function get_delivery_date() {       
        $jckwds_date=OrderMeta::query()->where(array('order_id'=>$this->order_id,'key'=>'jckwds_date'))->first();
        $date='-';
        if(isset($jckwds_date) && !empty($jckwds_date->value)){
             $date=date('F j, Y', strtotime(isset($jckwds_date->value)?$jckwds_date->value:''));
        }
        return $date;

    }


    public static function get_recent() {  

        $customer_query=DB::table('customers')->select('wp_id as rowid','customers.wp_id','first_name AS col1','last_name AS col2','billing_country AS col3','customer_type AS col4','date_created_gmt as date');
       $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
           $customers=new Customers();
           $customers->categories_purchased(array('from'=>$cat),'in_list',$customer_query,'','');  
        }


        $users = DB::table('orders')
                ->select('id as rowid','customer_id','billing_first_name AS col1','billing_last_name AS col2','total AS col3','status AS col4','date_modified_gmt as date')
                ->union($customer_query);
      

       
        

        $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $orders=new Orders();
         $orders->order_product_category(array('from'=>$cat),'in_list',$users,'','');  
         }

        $users->orderBy('date','desc');

   
        $data=$users->take(30)->get();
        return $data;
    }

    public static function get_recent_orders() {       
        $users = DB::table('orders')
                ->select('id as rowid','billing_first_name AS col1','billing_last_name AS col2','total AS col3','status AS col4','date_modified_gmt as date');
        $users->orderBy('date','desc');

      
        $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $orders=new Orders();
         $orders->order_product_category(array('from'=>$cat),'in_list',$users,'','');  
         }

   
        $data=$users->take(30)->get();
        return $data;

    }

    public static function get_recent_customers() {       
        $users = DB::table('customers')->select('wp_id as rowid','first_name AS col1','last_name AS col2','billing_country AS col3','customer_type AS col4','date_created_gmt as date');
          $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $customers=new Customers();
         $customers->categories_purchased(array('from'=>$cat),'in_list',$users,'','');  
         }

        $users->orderBy('date','desc');

      
   
        $data=$users->take(30)->get();
        return $data;
      

    }

    /**
  * Get searched, segment and orderby filtered data to export
  *
  *@param $postData(Post data)
  *
  *@return Data to export
  */
  public function getSearchData($searh,$limit=3){
   
        if($searh)
             $query = Order::query();
            $query->select(
                DB::raw('orders.id as order_id'),
                DB::raw('CONCAT("#", orders.number) as order_number'),
                DB::raw('orders.date_created_gmt as order_created_at'),
                DB::raw('orders.shipping_total as total_shipping'),
                DB::raw('orders.discount_total as total_discount'),
                DB::raw('orders.final_order_item_count as total_items'),
                DB::raw('orders.total as total'),
                DB::raw('REPLACE(orders.total_refund, "-", "") as total_refunds'),
                DB::raw('orders.billing_first_name as billing_address_first_name'),
                DB::raw('orders.billing_last_name as billing_address_last_name'),
                DB::raw('orders.billing_company as billing_address_company'),
                DB::raw('orders.billing_address_1 as billing_address_address_1'),
                DB::raw('orders.billing_address_2 as billing_address_address_2'),
                DB::raw('orders.billing_city as billing_address_city'),
                DB::raw('orders.billing_state as billing_address_state'),
                DB::raw('orders.billing_zip as billing_address_postcode'),
                DB::raw('orders.billing_country as billing_address_country'),
                DB::raw('orders.billing_email as billing_address_email'),
                DB::raw('orders.billing_phone as billing_address_phone'),
                DB::raw('orders.shipping_first_name as shipping_address_first_name'),
                DB::raw('orders.shipping_last_name as shipping_address_last_name'),
                DB::raw('orders.shipping_company as shipping_address_company'),
                DB::raw('orders.shipping_address_1 as shipping_address_address_1'),
                DB::raw('orders.shipping_address_2 as shipping_address_address_2'),
                DB::raw('orders.shipping_city as shipping_address_city'),
                DB::raw('orders.shipping_state as shipping_address_state'),
                DB::raw('orders.shipping_zip as shipping_address_postcode'),
                DB::raw('orders.shipping_country as shipping_address_country'),
                DB::raw('orders.date_modified_gmt as order_updated_at'),
                DB::raw('orders.date_completed_gmt as order_completed_at'),
                DB::raw('orders.date_paid_gmt as order_paid_at'),
                DB::raw('orders.customer_ip_address as customer_ip')
               
           
            );

        if (!empty($searh)) {
          
            $query->when($searh, function ($q) use($searh){
                $q->where( DB::raw('concat(orders.billing_first_name," ",orders.billing_last_name)'), 'like', '%' .$searh . '%');                   
                $q->orWhere('orders.billing_first_name', 'like', '%' . $searh . '%');
                $q->orWhere('orders.billing_last_name', 'like', '%' . $searh . '%');
                $q->orWhere('orders.billing_email', 'like', '%' . $searh . '%');
                $q->orWhere('orders.id', 'like', '%' . $searh . '%');
                return $q->orWhere('orders.billing_city', 'like', '%' . $searh . '%');
            });
      
        }  


         $current_role=Auth::user()->role->slug;
        $cat=[];
        if($current_role=='producer'){
          $users_categories=Auth::user()->users_categories;
          if(!empty($users_categories)){
            $cat=json_decode($users_categories,true);
          }
        }
        if($current_role=='producer'){
         $orders=new Orders();
         $orders->order_product_category(array('from'=>$cat),'in_list',$query,'','');  
         }
     

        
        $data = $query->get()->take($limit);     

         return $data;
    }

}
