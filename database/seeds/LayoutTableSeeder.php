<?php

use Illuminate\Database\Seeder;
Use App\Model\Layout;
Use App\Model\LayoutItem;

class LayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layouts=[
            [               
	            "name"=>"Default",
	            "is_public"=>1,
	            "full_page"=>0,
	            "is_default"=>1,	           
	            "items"=>[
	            	[
	            		"items"=>'{"item_type":"report","val":"revenue_net","hovertext":"Gross sales less taxes, fees, shipping and refunds made in this period.","text":"Net Revenue","link":"reports/revenue","color":"#1c7cd6"}',
	            		"sort"=>1
	            	],
	            	[
	            		"items"=>'{"item_type":"report","val":"orders_count","hovertext":"Orders made in this period.","text":"Orders","link":"reports/orders","color":"#1c7cd6"}',
	            		"sort"=>2
	            	],
	            	[
	            		"items"=>'{"item_type":"report","val":"customers_new","hovertext":"Customers that joined in this period.","text":"New Customers","link":"reports/customers","color":"#4c6ef5"}',
	            		"sort"=>3
	            	],
	            	[
	            		"items"=>'{"item_type":"report","val":"orders_items_sold","hovertext":"Item sold in this period.","text":"Items Sold","link":"products","color":"#4c6ef5"}',
	            		"sort"=>4
	            	],
	            	[
	            		"items"=>'{"item_type":"report","val":"refunds_amount","hovertext":"Amount refunded in this period.","text":"Refunded","link":"reports/revenue","color":"#d6336c"}',
	            		"sort"=>5
	            	],
	            	[
	            		"items"=>'{"item_type":"report","val":"refunds_count","hovertext":"The # of refunds made in this period.","text":"Refunds","link":"reports/revenue","color":"#d6336c"}',
	            		"sort"=>6
	            	],
	            	[
	            		"items"=>'{"item_type":"kpi","val":"orders_average_order_net","hovertext":"Net sales in this period divided by orders made.","text":"Average Order Net","color":"#4c6ef5"}',
	            		"sort"=>7
	            	],
	            	[
	            		"items"=>'{"item_type":"kpi","val":"orders_average_order_items","hovertext":"Items sold in this period less orders made.","text":"Average Order Items","color":"#4c6ef5"}',
	            		"sort"=>8
	            	],
	            	[
	            		"items"=>'{"item_type":"kpi","val":"customers_average_lifetime_value","hovertext":"Average total spend by customers created in this period, over their lifetime (not just from orders the customers mase in this period).","text":"Average Customer LTV","color":"#4c6ef5"}',
	            		"sort"=>9
	            	],
	            	[
	            		"items"=>'{"item_type":"kpi","val":"customers_average_lifetime_orders","hovertext":"Average # of orders by customers created in this period, over their lifetime (not just from orders the customers mase in this period).","text":"Average Customer Orders","color":"#4c6ef5"}',
	            		"sort"=>10
	            	],
	            	[
	            		"items"=>'{"item_type":"heading","val":"Products & Orders","half_size":0}',
	            		"sort"=>11
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_list","segment_id":"18","segment_name":"All","val":"products","text":"Products","orderbyval":"net_sold","orderby":"desc","heading":"Top Sellers","count":3,"color":"#7048e8"}',
	            		"sort"=>12
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_list","segment_id":"16","segment_name":"Failed Orders","val":"orders","text":"Orders","orderbyval":"orders.date_created_gmt","orderby":"desc","heading":"Recent Failed Orders","count":3,"color":"#7048e8"}',
	            		"sort"=>13
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"2","segment_name":"Single Order Customers","val":"customers","text":"Customers","stattext":"Count","orderby":"desc","statval":"count","count":3,"color":"#1c7cd6"}',
	            		"sort"=>14
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"3","segment_name":"Repeat Customers","val":"customers","text":"Customers","stattext":"Count","orderby":"desc","statval":"count","count":3,"color":"#1c7cd6"}',
	            		"sort"=>15
	            	],
	            	[
	            		"items"=>'{"item_type":"heading","val":"Customer Segments","half_size":0}',
	            		"sort"=>16
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"1","segment_name":"VIP","val":"customers","text":"Customers","stattext":"All Stats","orderby":"desc","statval":"all","count":3,"color":"#1c7cd6"}',
	            		"sort"=>17
	            	]
	            ]
            ],
            [
	            "name"=>"Customers",
	            "is_public"=>1,
	            "full_page"=>0,
	            "is_default"=>1,	          
	            "items"=>[
	            	[
	            		"items"=>'{"item_type":"report","val":"customers_new","hovertext":"Customers that joined in this period.","text":"New Customers","link":"reports/customers","color":"#d6336c"}',
	            		"sort"=>1
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"9","segment_name":"Registered Customers","val":"customers","text":"Customers","stattext":"Average LTV","orderby":"desc","statval":"average_ltv","count":3,"color":"#37b24d"}',
	            		"sort"=>2
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"8","segment_name":"Checked Out As Guests","val":"customers","text":"Customers","stattext":"Average LTV","orderby":"desc","statval":"average_ltv","count":3,"color":"#37b24d"}',
	            		"sort"=>3
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"3","segment_name":"Repeat Customers","val":"customers","text":"Customers","stattext":"All Stats","orderby":"desc","statval":"all","count":3,"color":"#37b24d"}',
	            		"sort"=>4
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"2","segment_name":"Single Order Customers","val":"customers","text":"Customers","stattext":"Count","orderby":"desc","statval":"count","count":3,"color":"#37b24d"}',
	            		"sort"=>5
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_total","segment_id":"3","segment_name":"Repeat Customers","val":"customers","text":"Customers","stattext":"Count","orderby":"desc","statval":"count","count":3,"color":"#4c6ef5"}',
	            		"sort"=>6
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_list","segment_id":"6","segment_name":"Lost","val":"customers","text":"Customers","orderbyval":"last_ordered","orderby":"desc","heading":"Lost Customers","count":3,"color":"#4c6ef5"}',
	            		"sort"=>7
	            	],
	            	[
	            		"items"=>'{"item_type":"segment_list","segment_id":"2","segment_name":"Single Order Customers","val":"customers","text":"Customers","orderbyval":"customers.date_created_gmt","orderby":"desc","heading":"Recent Customers","count":3,"color":"#7048e8"}',
	            		"sort"=>8
	            	]	            	
	            ]
            ]
        ];

		array_map(function($layout) {
			$layout_items_list = $layout;  
			unset($layout['items']);

           $lid = Layout::updateorcreate(['name'=>$layout['name']],$layout); 
           $layoutItem = array_map(function($items) {            
	            return new LayoutItem([
	                   'items' => $items['items'],
	                    'sort' => $items['sort']               
	                ]);
	        },$layout_items_list['items']);  
	        $lid->item()->saveMany($layoutItem);
        }, $layouts);  

    }
}
