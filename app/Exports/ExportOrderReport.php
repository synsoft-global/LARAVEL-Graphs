<?php
/**
 * Description: Order Report Export file (Formats data to be export).
 * Version: 1.0.0
 * Author: Synsoft Global
 * Author URI: https://www.synsoftglobal.com/
 *
 */
namespace App\Exports;

use App\Model\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Model\ExportSetting;
use Maatwebsite\Excel\Concerns\Exportable;
use Auth,DB;

class ExportOrderReport implements FromArray, WithHeadings, WithMapping
{


	use Exportable;
    private $data;
    private $col;
    private $alldata;
    public function __construct($alldata, $order_by){
        
        //Getting column headings       
        $this->col = array($order_by, "order_count", "gross_sales","net_sales", "refunds", "discounts", "taxes","shipping","fees");
        $this->alldata = $alldata;
        $this->order_by = $order_by;
    }

    /**
    * @return \Illuminate\Support\Collection
    *
    * @param
    *
    * Get collection according to setting map, headings and getCsvSettings 
    */

    public function array(): array
    {

        return $this->alldata;
    }
    
    /**
    *
    * Including file heading with delimeter
    * @return Array
    */ 
    public function headings(): array
    {   $head = explode('_', $this->order_by);
        $heading = (isset($head[0])?ucfirst($head[0]):'').' '.(isset($head[1])?ucfirst($head[1]):'')." ".(isset($head[2])?ucfirst($head[2]):'');
        return[
            $heading, 
            'Orders',
            'Gross',
            'Net',
            'Refunds',
            'Discounts',
            'Taxes',
            'Shipping',
            'Fees'
            
        ];
    }   

    /**
    *
    * Including delimeter in content
    * @return Array
    */   
    public function map($row): array{

        $fields = array();
        foreach($this->col as $key => $value){
            $fields[] = !empty($row[$value])?$row[$value]:'0'; 
        }     
        return $fields;
    }
    
}
