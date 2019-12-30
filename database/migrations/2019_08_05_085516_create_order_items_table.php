<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');          
            $table->unsignedBigInteger('order_id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('variation_id')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('tax_class')->nullable();
            $table->decimal('subtotal',10, 2)->nullable();
            $table->decimal('subtotal_tax',10, 2)->nullable();
            $table->decimal('total',10, 2)->nullable();
            $table->decimal('total_tax',10, 2)->nullable();
            $table->text('taxes')->nullable();           
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->dateTime('date_created')->nullable()->default('0000-00-00 00:00:00');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->timestamps();

            $table->index('product_id');
            $table->index('order_id');
            $table->index('variation_id');
            $table->index('date_created');  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
