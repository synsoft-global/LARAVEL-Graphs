<?php
use App\Model\Product;
use App\Model\Category;
use App\Model\Customer;
use App\Model\Order;
use App\Model\Coupon;
use App\Model\Segment;
use App\Model\userRole;
use App\Model\User;
use App\Model\ProductCategory;
use App\Model\storeData;
use App\Model\ProductTag;
use Illuminate\Http\Request;
Use App\Helpers\OrderHelper;
Use App\Helpers\CustomerHelper;
use Carbon\Carbon;
if (! function_exists('get_page_title')) {
    /**
     * Get Page Title
     *
     * @param $request1,$request2
     *
     * @return string $title
     *
     */
    function get_page_title($request1,$request2){
        $title='Reporting Tool';
          if(Auth::check()){
            if($request1 == 'dashboard'){
                 $title=' Dashboard | Reporting Tool';
             }
            else if($request1 == 'reports' && $request2 == 'revenue'){
                $title='Revenue Report | Reporting Tool';
            }
            else if($request1 == 'reports' && $request2 == 'orders'){
                $title='Orders Report | Reporting Tool';
            }
             
            else if($request1 == 'reports' && $request2 == 'refunds'){
                $title='Refunds Report | Reporting Tool';
            }
            else if($request1 == 'reports' && $request2 == 'customers'){
                $title='Customers Report | Reporting Tool';
            }
            else if($request1 == 'orders' || $request1== 'order'){
                $title='Orders | Reporting Tool';
            }
            else if($request1 == 'orders_segments'){
                $title='Segments - Orders';
            }
            else if($request1 == 'refunds'){
                $title='Refunds | Reporting Tool';
            }
            else if($request1 == 'customers' || $request1 == 'customer'){
                $title='Customers | Reporting Tool';
            }
           else if($request1 == 'segments' && $request2 == 'customers'){
                 $title='Segments - Customers';
             }
           else if($request1 == 'products' || $request1 == 'product'){
                $title='Products | Reporting Tool ';
            }
           else if($request1 == 'categories'){
               $title=' Product Categories | Reporting Tool';
            }
           else if($request1 == 'product-groups'){
                $title='Product Groups | Reporting Tool ';
            }
           else if($request1 == 'export_list'){
                $title='Exports | Reporting Tool';
            }
            else if($request1 == 'file_manager'){
                $title='File Manager | Reporting Tool';
            }
            else if($request1 == 'social_feed'){
                $title='Social Feed | Reporting Tool';
            }
            else if($request1 == 'users'){
                $title='Users | Reporting Tool';
            }
          }else{
            $title='Reporting Tool | Login';
          }
          
        return  $title;
    }
}

if (! function_exists('get_countries')) {
/**
 * Get all countries.
 *
 * @return array
 */
    function get_countries() {

        $countries = include 'countries.php';        
        return $countries;
    }
}

if (! function_exists('get_page_title')) {
    /**
     * Get Page Title
     *
     * @param $request1,$request2
     *
     * @return string $title
     *
     */
    function get_page_title($request1,$request2){
        $title='Reporting Tool';
          if(Auth::check()){
            if($request1 == 'dashboard'){
                 $title=' Dashboard | Reporting Tool';
             }
            else if($request1 == 'reports' && $request2 == 'revenue'){
                $title='Revenue Report | Reporting Tool';
            }
            else if($request1 == 'reports' && $request2 == 'orders'){
                $title='Orders Report | Reporting Tool';
            }
             
            else if($request1 == 'reports' && $request2 == 'refunds'){
                $title='Refunds Report | Reporting Tool';
            }
            else if($request1 == 'reports' && $request2 == 'customers'){
                $title='Customers Report | Reporting Tool';
            }
            else if($request1 == 'orders' || $request1== 'order'){
                $title='Orders | Reporting Tool';
            }
            else if($request1 == 'orders_segments'){
                $title='Segments - Orders';
            }
            else if($request1 == 'refunds'){
                $title='Refunds | Reporting Tool';
            }
            else if($request1 == 'customers' || $request1 == 'customer'){
                $title='Customers | Reporting Tool';
            }
           else if($request1 == 'segments' && $request2 == 'customers'){
                 $title='Segments - Customers';
             }
           else if($request1 == 'products' || $request1 == 'product'){
                $title='Products | Reporting Tool ';
            }
           else if($request1 == 'categories'){
               $title=' Product Categories | Reporting Tool';
            }
           else if($request1 == 'product-groups'){
                $title='Product Groups | Reporting Tool ';
            }
           else if($request1 == 'export_list'){
                $title='Exports | Reporting Tool';
            }
            else if($request1 == 'file_manager'){
                $title='File Manager | Reporting Tool';
            }
            else if($request1 == 'social_feed'){
                $title='Social Feed | Reporting Tool';
            }
            else if($request1 == 'users'){
                $title='Users | Reporting Tool';
            }
          }else{
            $title='Reporting Tool | Login';
          }
          
        return  $title;
    }
}
if (! function_exists('get_currency_symbol')) {
/**
 * Get Currency symbol.
 *
 * @param string $currency Currency. (default: '').
 * @return string
 */
    function get_currency_symbol( $currency = '' ) {
        if ( ! $currency ) {
            $currency = 'USD';
        }

        $symbols   = 
            
        array(
                'AED' => '&#x62f;.&#x625;',
                'AFN' => '&#x60b;',
                'ALL' => 'L',
                'AMD' => 'AMD',
                'ANG' => '&fnof;',
                'AOA' => 'Kz',
                'ARS' => '&#36;',
                'AUD' => '&#36;',
                'AWG' => 'Afl.',
                'AZN' => 'AZN',
                'BAM' => 'KM',
                'BBD' => '&#36;',
                'BDT' => '&#2547;&nbsp;',
                'BGN' => '&#1083;&#1074;.',
                'BHD' => '.&#x62f;.&#x628;',
                'BIF' => 'Fr',
                'BMD' => '&#36;',
                'BND' => '&#36;',
                'BOB' => 'Bs.',
                'BRL' => '&#82;&#36;',
                'BSD' => '&#36;',
                'BTC' => '&#3647;',
                'BTN' => 'Nu.',
                'BWP' => 'P',
                'BYR' => 'Br',
                'BYN' => 'Br',
                'BZD' => '&#36;',
                'CAD' => '&#36;',
                'CDF' => 'Fr',
                'CHF' => '&#67;&#72;&#70;',
                'CLP' => '&#36;',
                'CNY' => '&yen;',
                'COP' => '&#36;',
                'CRC' => '&#x20a1;',
                'CUC' => '&#36;',
                'CUP' => '&#36;',
                'CVE' => '&#36;',
                'CZK' => '&#75;&#269;',
                'DJF' => 'Fr',
                'DKK' => 'DKK',
                'DOP' => 'RD&#36;',
                'DZD' => '&#x62f;.&#x62c;',
                'EGP' => 'EGP',
                'ERN' => 'Nfk',
                'ETB' => 'Br',
                'EUR' => '&euro;',
                'FJD' => '&#36;',
                'FKP' => '&pound;',
                'GBP' => '&pound;',
                'GEL' => '&#x20be;',
                'GGP' => '&pound;',
                'GHS' => '&#x20b5;',
                'GIP' => '&pound;',
                'GMD' => 'D',
                'GNF' => 'Fr',
                'GTQ' => 'Q',
                'GYD' => '&#36;',
                'HKD' => '&#36;',
                'HNL' => 'L',
                'HRK' => 'kn',
                'HTG' => 'G',
                'HUF' => '&#70;&#116;',
                'IDR' => 'Rp',
                'ILS' => '&#8362;',
                'IMP' => '&pound;',
                'INR' => '&#8377;',
                'IQD' => '&#x639;.&#x62f;',
                'IRR' => '&#xfdfc;',
                'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
                'ISK' => 'kr.',
                'JEP' => '&pound;',
                'JMD' => '&#36;',
                'JOD' => '&#x62f;.&#x627;',
                'JPY' => '&yen;',
                'KES' => 'KSh',
                'KGS' => '&#x441;&#x43e;&#x43c;',
                'KHR' => '&#x17db;',
                'KMF' => 'Fr',
                'KPW' => '&#x20a9;',
                'KRW' => '&#8361;',
                'KWD' => '&#x62f;.&#x643;',
                'KYD' => '&#36;',
                'KZT' => 'KZT',
                'LAK' => '&#8365;',
                'LBP' => '&#x644;.&#x644;',
                'LKR' => '&#xdbb;&#xdd4;',
                'LRD' => '&#36;',
                'LSL' => 'L',
                'LYD' => '&#x644;.&#x62f;',
                'MAD' => '&#x62f;.&#x645;.',
                'MDL' => 'MDL',
                'MGA' => 'Ar',
                'MKD' => '&#x434;&#x435;&#x43d;',
                'MMK' => 'Ks',
                'MNT' => '&#x20ae;',
                'MOP' => 'P',
                'MRO' => 'UM',
                'MUR' => '&#x20a8;',
                'MVR' => '.&#x783;',
                'MWK' => 'MK',
                'MXN' => '&#36;',
                'MYR' => '&#82;&#77;',
                'MZN' => 'MT',
                'NAD' => '&#36;',
                'NGN' => '&#8358;',
                'NIO' => 'C&#36;',
                'NOK' => '&#107;&#114;',
                'NPR' => '&#8360;',
                'NZD' => '&#36;',
                'OMR' => '&#x631;.&#x639;.',
                'PAB' => 'B/.',
                'PEN' => 'S/',
                'PGK' => 'K',
                'PHP' => '&#8369;',
                'PKR' => '&#8360;',
                'PLN' => '&#122;&#322;',
                'PRB' => '&#x440;.',
                'PYG' => '&#8370;',
                'QAR' => '&#x631;.&#x642;',
                'RMB' => '&yen;',
                'RON' => 'lei',
                'RSD' => '&#x434;&#x438;&#x43d;.',
                'RUB' => '&#8381;',
                'RWF' => 'Fr',
                'SAR' => '&#x631;.&#x633;',
                'SBD' => '&#36;',
                'SCR' => '&#x20a8;',
                'SDG' => '&#x62c;.&#x633;.',
                'SEK' => '&#107;&#114;',
                'SGD' => '&#36;',
                'SHP' => '&pound;',
                'SLL' => 'Le',
                'SOS' => 'Sh',
                'SRD' => '&#36;',
                'SSP' => '&pound;',
                'STD' => 'Db',
                'SYP' => '&#x644;.&#x633;',
                'SZL' => 'L',
                'THB' => '&#3647;',
                'TJS' => '&#x405;&#x41c;',
                'TMT' => 'm',
                'TND' => '&#x62f;.&#x62a;',
                'TOP' => 'T&#36;',
                'TRY' => '&#8378;',
                'TTD' => '&#36;',
                'TWD' => '&#78;&#84;&#36;',
                'TZS' => 'Sh',
                'UAH' => '&#8372;',
                'UGX' => 'UGX',
                'USD' => '&#36;',
                'UYU' => '&#36;',
                'UZS' => 'UZS',
                'VEF' => 'Bs F',
                'VES' => 'Bs.S',
                'VND' => '&#8363;',
                'VUV' => 'Vt',
                'WST' => 'T',
                'XAF' => 'CFA',
                'XCD' => '&#36;',
                'XOF' => 'CFA',
                'XPF' => 'Fr',
                'YER' => '&#xfdfc;',
                'ZAR' => '&#82;',
                'ZMW' => 'ZK'        
        );
        $currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

        return $currency_symbol;
    }
}

if(!function_exists('checkPermission')){
/**
 * Get list of logged in user's not permitted menu  .
 *
 * @since 2.0.5
 *
 * @param $user_role_slug (Logged in user role), $permission_type  (type of permission is url, action button, sidebar menu or navigation menu)
 *
 * @return Array (All not permitted list)
 */
    function checkPermission($user_role_slug, $permission_type){
        $not_permitted = array(
                'admin' => array(
                                'url_param'     => array(),
                                'action_btn'    => array(),
                                'sidebar_menu'  => array(),
                                'nav_menu'      => array(),
                            ),
                'manager' => array(
                                'url_param'     => array('view_settings'),
                                'action_btn'    => array(),
                                'sidebar_menu'  => array(),
                                'nav_menu'      => array('view_settings'),
                            ),
                'sales_person' => array(
                                'url_param'=>array('view_settings'),
                                'action_btn'=>array('add_user', 'edit_user', 'delete_user'),
                                'sidebar_menu'=>array(),
                                'nav_menu'=>array('view_settings'),
                            ),
                'producer' => array(
                                'url_param'=>array('reports', 'users', 'view_settings'),
                                'action_btn'=>array(),
                                'sidebar_menu'=>array('reports'),
                                'nav_menu'=>array('users', 'view_settings'),
                            ),
            );  

        return $not_permitted[$user_role_slug][$permission_type];
    }
}

if (! function_exists('check_active_case')) {
/**
 * Get ascending or descending class based on session value.
 *
 * @since 2.0.5
 *
 * @param $key,$val
 * @return String $active( Class)
 */
    function check_active_case($key,$val){
        $active='';
        if(session($key) && session($key)==$val.'__asc'){
            $active='sorting_asc';
        }else if((session($key) && session($key)==$val.'__desc') ){
            $active='sorting_desc';
        }

      return $active;
    }
}

if (! function_exists('comparePercentage')) {
/**
 * Get percentage.
 *
 * @since 2.0.5
 *
 * @param $data, $data_to_compare.
 * @return integer $compare_data.
 */
    function comparePercentage($data, $data_to_compare) {
        if($data == 0 || $data_to_compare ==0) {
          $compare_data = 0;
        }else{
          $compare_data = round((($data - $data_to_compare) * 100/ $data_to_compare), 1);
        }

        return $compare_data;
    }
}

 if (! function_exists('get_country_name')) {
    /**
     * Get country name
     *
     * 
     * @return string
     */
    function get_country_name($code)
    {
         $countries = get_countries(); 
        return (!empty($countries[$code])) ? $countries[$code] : $code;       

    }
}

if (! function_exists('get_order_name')) {
    /**
     * Get order name
     *
     * 
     * @return string
     */
    function get_order_name($code)
    {
         $orders=array(
            'completed'=>'Completed',
            'on-hold'=>'On hold',
            'processing'=>'Processing',
            'refunded'=>'Refunded',
            'pending'=>'Pending Payment',
            'cancelled'=>'Cancelled',
            'failed'=>'Failed',
        );
        return (!empty($orders[$code])) ? $orders[$code] : $code;       

    }
}
