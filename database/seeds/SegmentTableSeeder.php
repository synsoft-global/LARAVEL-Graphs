<?php

use Illuminate\Database\Seeder;

class SegmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $segments=[
            [               
            "segment_name"=>"VIP",
            "module_type"=>"customers",
            "description"=>"Customers with a LTV over {{vip_spend_atleast}}.",
            "filters_data"=>'[{"filter":"total_spent","option":"greater_than","from":"70892","column":"total_spent","method":"total_spent"}]',
            "default"=>1,
            "is_public"=>1,
            ],
            [
                "segment_name"=>"Single Order Customers",
                "module_type"=>"customers",
                "description"=>"Customers that made a single order in the given period.",
                "filters_data"=>'[{"filter":"order_count","option":"equal_to","from":"1","column":"order_count","method":"order_count"}]',
                "is_public"=>1,
                "default"=>1,
            ],
            [
                "segment_name"=>"Repeat Customers",
                "module_type"=>"customers",
                "description"=>"Customers that made 2 or more orders in the given period.",
                "filters_data"=>'[{"filter":"order_count","option":"greater_than","from":"1","column":"order_count","method":"order_count"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Zero Order Customers",
                "module_type"=>"customers",
                "description"=>"Customers that have made 0 orders in the given period.",
                "filters_data"=>'[{"filter":"order_count","option":"equal_to","from":"0","column":"order_count","method":"order_count"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"At Risk",
                "module_type"=>"customers",
                "description"=>"Customers at risk of being lost (no orders in the past {{customer_segment_at_risk_after_days}} days but ordered within the past {{customer_segment_lost_after_days}} days).",
                "filters_data"=>'[{"filter":"last_ordered","option":"over","from":"12","to":"days","column":"last_ordered","method":"last_ordered"},{"filter":"last_ordered","option":"in_the_past","from":"15","to":"days","column":"last_ordered","method":"last_ordered"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Lost",
                "module_type"=>"customers",
                "description"=>"Customers that have been lost (no orders in the past {{customer_segment_lost_after_days}} days).",
                "filters_data"=>'[{"filter":"last_ordered","option":"over","from":"12","to":"days","column":"last_ordered","method":"last_ordered"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Joined Last Month",
                "module_type"=>"customers",
                "description"=>"Customers that joined last month (August).",
                "filters_data"=>'[{"filter":"customer_joined","option":"in_the_period","from":"last_month","to":"","column":"customers.date_created","method":"customer_joined"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Checked Out As Guests",
                "module_type"=>"customers",
                "description"=>"Customers that checked out as a guest.",
                "filters_data"=>'[{"filter":"customer_type","option":"is","from":"guest","to":"","column":"customers.customer_type","method":"customer_type"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Registered Customers",
                "module_type"=>"customers",
                "description"=>"Customers that have registered and have an account.",
                "filters_data"=>'[{"filter":"customer_type","option":"is","from":"customer","to":"","column":"customers.customer_type","method":"customer_type"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"EU Customers",
                "module_type"=>"customers",
                "description"=>"Customers with a billing country that is a European Union member state.",
                "filters_data"=>'[{"filter":"billing_country","option":"in_list","from":["AT","BE","BG","CY","CZ","DE","DK","EE","ES","FI","FR","GB","GR","HR","HU","IE","IT","LT","LU","LV","MT","NL","PL","PT","RO","SE","SI","SK"],"to":"","column":"customers.billing_country","method":"billing_country"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"All",
                "module_type"=>"customers",
                "description"=>"",
                "filters_data"=>'[]',
                "is_public"=>1,
                "default"=>1
            ],
            [
                "segment_name"=>"All",
                "module_type"=>"orders",
                "description"=>"",
                "filters_data"=>'[]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"EU Orders",
                "module_type"=>"orders",
                "description"=>"Orders with a billing country that is a European Union member state",
                "filters_data"=>'[{"filter":"billing_country","option":"in_list","from":["AT","BE","BG","CY","CZ","DE","DK","EE","ES","FI","FR","GB","GR","HR","HU","IE","IT","LT","LU","LV","MT","NL","PL","PT","RO","SE","SI","SK"],"to":"","column":"orders.billing_country","method":"billing_country"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Guest Orders",
                "module_type"=>"orders",
                "description"=>"Orders that were made by users who checked out as guests (without registering)",
                "filters_data"=>'[{"filter":"customer_type","option":"is","from":"guest","to":"","column":"customers.customer_type","method":"customer_role"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Customer Orders",
                "module_type"=>"orders",
                "description"=>"Orders that were made by users who checked out as registred customers.",
                "filters_data"=>'[{"filter":"customer_type","option":"is","from":"customer","to":"","column":"customers.customer_type","method":"customer_role"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Failed Orders",
                "module_type"=>"orders",
                "description"=>"Orders that have the *failed* status.",
                "filters_data"=>'[{"filter":"order_status","option":"in_list","from":"refunded","to":"","column":"status","method":"common_value_search"}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Successfull Orders",
                "module_type"=>"orders",
                "description"=>"Orders that *do not* have a status that is excluded from totals. Excluded statuses included: pending, failed, cancelled.",
                "filters_data"=>'[{"filter":"order_status","option":"not_in_list","from":"refunded","to":"","column":"status","method":"common_value_search"}]',
                "is_public"=>1,
                "default"=>1
            ],
             [
                "segment_name"=>"All",
                "module_type"=>"products",
                "description"=>"",
                "filters_data"=>'[]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Variable Products",
                "module_type"=>"products",
                "description"=>"Variable Products Products that are of \"variable\" type",
                "filters_data"=>'[{"filter":"type","column":"type","method":"type","option":"in_list","from":["variable"],"to":""}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Simple Products",
                "module_type"=>"products",
                "description"=>"Products that are of \"simple\" type",
                "filters_data"=>'[{"filter":"type","rowid":1,"column":"type","method":"type","option":"in_list","from":["simple"],"to":""}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"Out of Stock",
                "module_type"=>"products",
                "description"=>"Products that their stock status set to \"out of stock\"",
                "filters_data"=>'[{"filter":"stock_status","column":"stock_status","method":"stock_status","option":"is","from":"outofstock","to":""}]',
                "is_public"=>1,
                "default"=>1
            ],[
                "segment_name"=>"In Stock",
                "module_type"=>"products",
                "description"=>"Products that their stock status set to \"in stock\"",
                "filters_data"=>'[{"filter":"stock_status","column":"stock_status","method":"stock_status","option":"is","from":"instock","to":""}]',
                "is_public"=>1,
                "default"=>1
            ],
             [
                "segment_name"=>"All",
                "module_type"=>"refunds",
                "description"=>"",
                "filters_data"=>'[]',
                "is_public"=>1,
                "default"=>1
            ],
        ];

		DB::table('segments')->insert($segments);  
    }
}
