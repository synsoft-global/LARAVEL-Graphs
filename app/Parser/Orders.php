<?php
/**
 * Description: Order helper for parse request data and insert related database.
 * Version: 1.0.0
 * Author: Synsoft Global
 * Author URI: https://www.synsoftglobal.com/
 *
 */
namespace App\Parser;

Use App\Model\Order;
Use App\Model\OrderMeta;
Use App\Model\OrderItem;
Use App\Model\OrderItemMeta;
Use App\Model\Refund;
Use App\Model\RefundMeta;
Use App\Model\OrderCoupon;
Use App\Model\OrderCouponMeta;
Use App\Model\RefundItem;
Use App\Model\OrderNote;
Use App\Model\RefundItemMeta;
use App\Model\storeData;
use App\Model\ShippingLines;
use App\Model\ShippingLinesMeta;
use App\Model\FeeLines;
use App\Model\FeeLinesMeta;
use App\Model\TaxLines;
use App\Model\TaxLinesMeta;
use Automattic\WooCommerce\Client;
Use App\Model\Customer;
use Eloquent;
class Orders
{

     protected $setting = '';
    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
     /** 
     *
     * @param $woocommerce
     */
    public function __construct()
    {
        $this->setting=storeData::whereIn('option_name',array('store_name','store_url','private_key','secret_key'))->get();
         $data['setting']=array();
          foreach($this->setting as $setting){
            $data['setting'][$setting->option_name]=$setting->option_value;
          }
          
        if(count($data['setting']) > 0){
           $this->woocommerce = new Client($data['setting']['store_url'], $data['setting']['private_key'], $data['setting']['secret_key'], [
                'version' => 'wc/v3',
                'verify_ssl' => false
            ]); 
        }
        
    }

    public static function create($content){ 
        global $order;      
        $order=Order::parse_order_data($content);
        //var_dump($order);die;
        $order_meta=Order::parse_order_meta($content);
        $oid= Orders::add_order($order,$order_meta,$content);
        return $oid;
    }
    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function update($content){
        global $order;     
        $order=Order::parse_order_data($content);
        $order_meta=Order::parse_order_meta($content);
        $oid= Orders::add_order($order,$order_meta,$content);     
        return $oid;
    }
    
    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function delete($content){
        global $order;     
       // $order=Order::parse_order_data($content);      
        //$oid = Order::where('id', $order['id'])->delete();
        $oid='';
        if(!empty($content) && isset($content->id)){
            $oid = Order::where('id', $content->id)->delete();  
        } 

        return $oid;
    }
    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function restore($content){
        global $order;     
        $order=Order::parse_order_data($content);
        $order_meta=Order::parse_order_meta($content);
        $oid= Orders::add_order($order,$order_meta,$content);
        return $oid;
    }
    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function add_order($order,$order_meta,$content){
        global $oid;  
        global $order_id;  
        global $woocommerce;          
        global $order;          
        global $refunds_results; 
        $settings=storeData::whereIn('option_name',array('store_name','store_url','private_key','secret_key'))->get();
         $data['setting']=array();
          foreach($settings as $setting){
            $data['setting'][$setting->option_name]=$setting->option_value;
          }
          
        if(count($data['setting']) > 0){
           $woocommerce = new Client($data['setting']['store_url'], $data['setting']['private_key'], $data['setting']['secret_key'], [
                'version' => 'wc/v3',
                'verify_ssl' => false
            ]); 
        }

    

        if($order['customer_id']==0){
           $customer=Order::parse_customer_data($content); 
           $uid = Customer::where('email', '=',$customer['email'])->first();           
           if($uid && $uid->id){             
             $order['customer_id']='g-'.$uid->id;                      
           }else{                   
            $uid = Customer::updateorcreate(['email'=>$customer['email']],$customer);             
            $order['customer_id']='g-'.$uid->id;           
            Customer::where(['id'=>$uid->id])->update(array(
                'wp_id'=>'g-'.$uid->id
             ));  
                    
           } 
                  
        }else{
              $customer_update=Order::parse_customer_update_data($content); 
               $uid = Customer::where('wp_id', '=',$customer_update['wp_id'])->first();          
               if($uid && $uid->id){             
                 Customer::updateorcreate(['wp_id'=>$customer_update['wp_id']],$customer_update);                     
               }
        }      

       
        $order_item=[];
        $order_item_ids=[];
        $order_item_count=0;
        $order['total_fees'] = 0; 

        if($content->line_items){
            foreach ($content->line_items as $key => $value) {
               $order_item_ids[]= $value->product_id;
               $order_item[]=array('name'=>$value->name,'quantity'=>$value->quantity,'id'=>$value->id,'image'=>'','product_id'=>$value->product_id);
              $order_item_count += $value->quantity;
            }
        }

        if($content->fee_lines){
            foreach ($content->fee_lines as $key => $value) {
               $order['total_fees'] += $value->total;
             
            }
        }

             
        

        $order['order_item_count'] = $order_item_count; 
        $order['order_item_ids'] = ",".implode(",", $order_item_ids).",";
        $order['order_item'] = json_encode($order_item); 

        if(!empty($content->coupon_lines) && !empty( $content->coupon_lines['0'])){

            $order['coupon_code']= $content->coupon_lines['0']->code;
        }

        //var_dump($order);
        //exit;
        
        $order_id=$order['id'];    

        $order['total_refund_item_count']=0;         
        $order['total_refund'] =0;
        $order['total_total_tax_refund'] =0;

       
        $order['order_coupon_count'] =count($content->coupon_lines);
        $order['final_total'] =0;
        $order['final_order_item_count'] =0;
        global $line_item_order;
        global $refund_item_order;
        $line_item_order=array(
            'refund_item_count'=>0,
            'total_tax_refund'=>0
        );
        $refund_item_order=array(
            'refund_item_ids'=>[],
            'refunds_items'=>[],
            'refund_item_count'=>0
        );
         if(isset($content->refunds) && count($content->refunds) > 0){  
       
             array_map(function($item) { 
                global $order_id; 
                global $woocommerce;  
                global $order;                     
              
                global $line_item_order;
                global $refund_item_order;
                $order['total_refund'] += $item->total;

                $refunds_results = $woocommerce->get("orders/$order_id/refunds/$item->id");            

                 if(isset($refunds_results->line_items) && count($refunds_results->line_items) > 0){

                    array_map(function($line_item) { 
                        global $line_item_order;       
                        global $refund_item_order;       
                       
                       $line_item_order['refund_item_count'] += $line_item->quantity;
                         
                       $line_item_order['total_tax_refund'] += $line_item->total_tax; 

                       $refund_item_order['refund_item_ids'][]= $line_item->id;

                       $refund_item_order['refunds_items'][]=array('name'=>$line_item->name,'quantity'=>$line_item->quantity,'id'=>$line_item->id,'image'=>'');
                       $refund_item_order['refund_item_count'] += 1;  



                      return $line_item;

                    },$refunds_results->line_items);
                                          
                }
                return;

            },$content->refunds);            
        }     

        $order['total_refund_item_count'] = $line_item_order['refund_item_count'];                         
        $order['total_total_tax_refund'] = $line_item_order['total_tax_refund']; 
        $order['final_total'] =$order['total']+$order['total_refund'];
        $order['final_order_item_count'] =$order['order_item_count']-$order['total_refund_item_count'];

       
          

        $oid = Order::updateorcreate(['id'=>$order['id']],$order); 

        $meta = array_map(function($meta) {            
            return new OrderMeta([
                   'key' => $meta['key'],
                    'value' => $meta['value']               
                ]);
        }, $order_meta);  
        $oid->meta()->saveMany($meta);

        if(isset($content->line_items) && count($content->line_items) > 0){   
             $order_item = array_map(function($item) { 
                global $oid;    
                global $order;                  
                $orderItem_I = OrderItem::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id,
                    'product_id' => $item->product_id
                 ],[
                    'name' => $item->name,     
                    'product_id' => $item->product_id ,
                    'variation_id' => $item->variation_id ,
                    'quantity' => $item->quantity ,
                    'price' => $item->price,
                    'sku' => $item->sku,
                    'tax_class' => $item->tax_class,
                    'subtotal' => $item->subtotal ,
                    'subtotal_tax' => $item->subtotal_tax ,
                    'total' => $item->total ,
                    'date_created' => $order['date_created'] ,
                    'taxes' => (!is_serialized($item->taxes )) ? maybe_serialize($item->taxes) : $item->taxes                  
                ]);
                $order_item_meta=Order::parse_order_meta($item->meta_data);
                 $order_item_meta_i = array_map(function($meta) {      
                    return new OrderMeta([
                           'key' => $meta['key'],
                            'value' => $meta['value']               
                        ]);
                }, $order_item_meta);  
                $orderItem_I->meta()->saveMany($order_item_meta_i);         

                return $orderItem_I;

            },$content->line_items);   

            $oid->order_item()->saveMany($order_item);
        }

        if(isset($content->coupon_lines) && count($content->coupon_lines) > 0){   
             $coupon_item = array_map(function($item) { 
                global $oid;        
                $orderItem_I = OrderCoupon::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id                 
                 ],[
                    'code' => $item->code,     
                    'discount' => $item->discount ,
                    'discount_tax' => $item->discount_tax                   
                ]);
                $coupon_item_meta=Order::parse_order_meta($item->meta_data);
                 $coupon_item_meta_i = array_map(function($meta) {      
                    return new OrderCouponMeta([
                           'key' => $meta['key'],
                            'value' => $meta['value']               
                        ]);
                }, $coupon_item_meta);  
                $orderItem_I->meta()->saveMany($coupon_item_meta_i);         

                return $orderItem_I;

            },$content->coupon_lines);   

            $oid->order_coupon()->saveMany($coupon_item);
        }

         if(isset($content->shipping_lines) && count($content->shipping_lines) > 0){   
             $shipping_lines = array_map(function($item) { 
                global $oid;    
                global $order;                  
                $shipping_lines_I = ShippingLines::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id                   
                 ],[
                    'method_title' => $item->method_title,     
                    'method_id' => $item->method_id,
                    'total' => $item->total,
                    'total_tax' => $item->total_tax,                    
                    'taxes' => (!is_serialized($item->taxes )) ? maybe_serialize($item->taxes) : $item->taxes                  
                ]);
                $shipping_lines_meta=Order::parse_order_meta($item->meta_data);
                $shipping_lines_meta_i = array_map(function($meta) {      
                    return new ShippingLinesMeta([
                           'key' => $meta['key'],
                            'value' => $meta['value']               
                        ]);
                }, $shipping_lines_meta);  
                $shipping_lines_I->meta()->saveMany($shipping_lines_meta_i);         

                return $shipping_lines_I;

            },$content->shipping_lines);   

            $oid->order_shipping_lines()->saveMany($shipping_lines);
        }

         if(isset($content->fee_lines) && count($content->fee_lines) > 0){   
             $fee_lines = array_map(function($item) { 
                global $oid;    
                global $order;                  
                $fee_lines_I = FeeLines::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id,                    
                 ],[
                    'name' => $item->name,     
                    'tax_class' => $item->tax_class ,
                    'tax_status' => $item->tax_status ,
                    'total' => $item->total,
                    'total_tax' => $item->total_tax,                   
                    'taxes' => (!is_serialized($item->taxes )) ? maybe_serialize($item->taxes) : $item->taxes                  
                ]);
                $fee_lines_meta=Order::parse_order_meta($item->meta_data);
                 $fee_lines_meta_i = array_map(function($meta) {      
                    return new FeeLinesMeta([
                           'key' => $meta['key'],
                            'value' => $meta['value']               
                        ]);
                }, $fee_lines_meta);  
                $fee_lines_I->meta()->saveMany($fee_lines_meta_i);         

                return $fee_lines_I;

            },$content->fee_lines);   

            $oid->order_fee_line()->saveMany($fee_lines);
        }

         if(isset($content->tax_lines) && count($content->tax_lines) > 0){   
             $tax_lines = array_map(function($item) { 
                global $oid;    
                global $order;                  
                $tax_lines_I = TaxLines::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id                   
                 ],[                      
                    'name' => $item->name,     
                    'tax_class' => $item->tax_class ,
                    'tax_status' => $item->tax_status ,
                    'total' => $item->total,
                    'total_tax' => $item->total_tax,                 
                    'taxes' => (!is_serialized($item->taxes )) ? maybe_serialize($item->taxes) : $item->taxes                  
                ]);
                $tax_lines_meta=Order::parse_order_meta($item->meta_data);
                $tax_lines_meta_i = array_map(function($meta) {      
                    return new TaxLinesMeta([
                           'key' => $meta['key'],
                            'value' => $meta['value']               
                        ]);
                }, $tax_lines_meta);  
                $tax_lines_I->meta()->saveMany($tax_lines_meta_i);         

                return $orderItem_I;

            },$content->tax_lines);   

            $oid->order_tax_lines()->saveMany($tax_lines);
        }


      

        if(isset($content->refunds) && count($content->refunds) > 0){  
       
             $refunds_item = array_map(function($item) { 
                global $oid; 
                global $woocommerce;  
                global $refund_id;     
                global $refunds_results;     
                global $refund_item_order;     
                global $order;           
               
                $refund_id=$item->id;                 

                $refunds_I = Refund::updateorcreate(['id' => $item->id,
                    'order_id' => $oid->id                  
                 ],[
                    'reason' => $item->reason,                       
                    'total' => $item->total ,
                    'order_number' => $order['number'],
                    'refund_item_ids' => ",".implode(",",$refund_item_order['refund_item_ids']).",",
                    'refunds_items' =>  json_encode($refund_item_order['refunds_items']) ,
                    'refund_item_count' => $refund_item_order['refund_item_count'] ,
                    'order_date_created' => $order['date_created'] ,             
                ]);

                $refunds_results = $woocommerce->get("orders/$oid->id/refunds/$item->id");

                if(!empty($refunds_results->meta_data) && count($refunds_results->meta_data) > 0){
                    $refunds_meta=Order::parse_order_meta($refunds_results->meta_data);
                     $refunds_meta_i = array_map(function($meta) {      
                        return new RefundMeta([
                            'key' => $meta['key'],
                            'value' => $meta['value']      
                        ]);
                    }, $refunds_meta);  
                    $refunds_I->meta()->saveMany($refunds_meta_i);
                } 


                $refunds_I = Refund::updateorcreate(['id' => $refunds_results->id,
                    'order_id' => $oid->id                  
                 ],[                        
                    'date_created' => $refunds_results->date_created ,
                    'date_created_gmt' => $refunds_results->date_created_gmt ,                  
                    'order_date_created' => $order['date_created'] ,             
                ]);

                 global $refund_result_date; 
                 $refund_result_date['date_created']=$refunds_results->date_created;
                 $refund_result_date['date_created_gmt']=$refunds_results->date_created_gmt;

                 if(isset($refunds_results->line_items) && count($refunds_results->line_items) > 0){   
                     $refunds_line_item = array_map(function($line_item) { 
                        global $oid; 
                        global $refund_id; 
                        global $order; 
                        global $refund_result_date; 

                        $RefundItem_I = RefundItem::updateorcreate(['id' => $line_item->id,
                            'refund_id' => $refund_id,
                            'product_id' => $line_item->product_id
                         ],[
                            'order_id' => $oid->id,  
                            'name' => $line_item->name,     
                            'product_id' => $line_item->product_id ,
                            'date_created' =>$refund_result_date['date_created'] ,
                            'date_created_gmt' => $refund_result_date['date_created_gmt'] ,
                            'variation_id' => $line_item->variation_id ,
                            'quantity' => $line_item->quantity ,
                            'subtotal' => $line_item->subtotal ,
                            'subtotal_tax' => $line_item->subtotal_tax ,
                            'total' => $line_item->total ,
                            'total_tax' => $line_item->total_tax ,
                            'order_date_created' => $order['date_created'] ,
                            'taxes' => (!is_serialized($line_item->taxes )) ? maybe_serialize($line_item->taxes) : $line_item->taxes                  
                        ]);
                        $refund_item_meta=Order::parse_order_meta($line_item->meta_data);
                         $refund_item_meta_i = array_map(function($meta) {      
                            return new RefundItemMeta([
                                   'key' => $meta['key'],
                                    'value' => $meta['value']               
                                ]);
                        }, $refund_item_meta);  
                        $RefundItem_I->meta()->saveMany($refund_item_meta_i);         

                        return $RefundItem_I;

                    },$refunds_results->line_items);   

                    $refunds_I->refund_item()->saveMany($refunds_line_item);
                }

                return $refunds_I;

            },$content->refunds);   

            $oid->order_refund()->saveMany($refunds_item);
        }


        $notes_results = $woocommerce->get("orders/$oid->id/notes");

       
         if(isset($notes_results) && count($notes_results) > 0){   
                 $notes_item = array_map(function($line_item) { 
                    global $oid;    
                    $OrderNote_I = OrderNote::updateorcreate([
                        'id' => $line_item->id,                        
                        'order_id' => $oid->id
                     ],[
                        'order_id' => $oid->id,     
                        'author' => $line_item->author ,
                        'note' => $line_item->note ,
                        'customer_note' => $line_item->customer_note ,
                        'date_created' => $line_item->date_created ,
                        'date_created_gmt' => $line_item->date_created_gmt                                        
                    ]);                     

                    return $OrderNote_I;

                },$notes_results);   

                Order::find($order_id)->order_note()->saveMany($notes_item);
            }
       

        return $oid;
    }
 

    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function update_order_status($orderids,$status){       
        $settings=storeData::whereIn('option_name',array('store_name','store_url','private_key','secret_key'))->get();
         $data['setting']=array();
          foreach($settings as $setting){
            $data['setting'][$setting->option_name]=$setting->option_value;
          }
          
        if(count($data['setting']) > 0){
           $woocommerce = new Client($data['setting']['store_url'], $data['setting']['private_key'], $data['setting']['secret_key'], [
                'version' => 'wc/v3',
                'verify_ssl' => false
            ]); 
        }

        $postData=[];
        foreach ($orderids as $key => $value) {
            $postData['update'][]=array('id'=>$value,'status'=>$status);
        }

        $orders_results = $woocommerce->post("orders/batch",$postData);
       
        if(!empty($orders_results) && count($orders_results->update) > 0){
            foreach($orders_results->update as $content){
                $req_dump='';
                $req_dump .= print_r($content, TRUE);
                $fp = fopen('request.log', 'a');
                fwrite($fp, $req_dump);
                fclose($fp);                 
                Eloquent::unguard();  
               
                $result=Order::where('id',$content->id)->delete();
                           
                $oid = Orders::Create($content);                          
            }           
           
        }

        return true;
    }

    /**
     * Returns the main instance of WC.
     *
     * @since  2.1
     * @return WooCommerce
     */
    public static function update_order_note($postData){      
        $settings=storeData::whereIn('option_name',array('store_name','store_url','private_key','secret_key'))->get();
         $data['setting']=array();
          foreach($settings as $setting){
            $data['setting'][$setting->option_name]=$setting->option_value;
          }
          
        if(count($data['setting']) > 0){
           $woocommerce = new Client($data['setting']['store_url'], $data['setting']['private_key'], $data['setting']['secret_key'], [
                'version' => 'wc/v3',
                'verify_ssl' => false
            ]); 
        }

       // $postData=[];
        //$postData['note']=$data['note'];
       // $postData['customer_note']=$data['customer_note'];
        $order_id=$postData['order_id'];

        $notes_results = $woocommerce->post("orders/$order_id/notes",$postData);

        if(!empty($notes_results)){             
             $notes_item = OrderNote::updateorcreate([
                'id' => $notes_results->id,                        
                'order_id' => $order_id
             ],[
                'order_id' => $order_id,     
                'author' => $notes_results->author ,
                'note' => $notes_results->note ,
                'customer_note' => $notes_results->customer_note ,
                'date_created' => $notes_results->date_created ,
                'date_created_gmt' => $notes_results->date_created_gmt                                        
            ]);    

            Order::find($order_id)->order_note()->save($notes_item);                      
           
        }

        return true;
    }

   
}
