<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');              
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('number')->nullable();
            $table->string('order_key')->nullable();
            $table->string('created_via')->nullable();
            $table->string('version')->nullable();
            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->dateTime('date_created')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_created_gmt')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_modified')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_modified_gmt')->nullable()->default('0000-00-00 00:00:00');
            
            $table->dateTime('date_paid')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_paid_gmt')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_completed')->nullable()->default('0000-00-00 00:00:00');
            $table->dateTime('date_completed_gmt')->nullable()->default('0000-00-00 00:00:00');
            $table->decimal('discount_total',10, 2)->nullable();
            $table->decimal('discount_tax',10, 2)->nullable();
            $table->decimal('shipping_total',10, 2)->nullable();
            $table->decimal('shipping_tax',10, 2)->nullable();
            $table->string('cart_tax')->nullable();
            $table->decimal('total',10, 2)->nullable();
            $table->decimal('total_tax',10, 2)->nullable();
            $table->string('prices_include_tax')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('customer_ip_address')->nullable();
            $table->string('customer_user_agent')->nullable();
            $table->string('customer_note')->nullable();           
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_company')->nullable();
            $table->string('billing_address_1')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_address_1')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('payment_method_title')->nullable();             
            $table->string('coupon_code')->nullable();           
            $table->string('transaction_id')->nullable();           
            $table->unsignedInteger('order_item_count')->nullable();  
            $table->text('order_item')->nullable();        
            $table->boolean('set_paid')->nullable();        
            $table->unsignedInteger('order_coupon_count')->nullable();        
            $table->text('order_item_ids')->nullable();      
            $table->unsignedInteger('total_refund_item_count')->nullable();   
            $table->decimal('total_refund',10, 2)->nullable();
            $table->decimal('total_fees',10, 2)->nullable();
            $table->decimal('total_total_tax_refund',10, 2)->nullable();
            $table->decimal('final_total',10, 2)->nullable(); 
            $table->unsignedInteger('final_order_item_count')->nullable(); 
            $table->timestamps();


            $table->index('final_total');
            $table->index('customer_id');
            $table->index('date_created_gmt');
       

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
