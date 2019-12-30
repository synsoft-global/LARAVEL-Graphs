<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCouponMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_coupon_metas', function (Blueprint $table) {
            $table->bigIncrements('id');          
            $table->unsignedBigInteger('order_coupon_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->foreign('order_coupon_id')
                ->references('id')
                ->on('order_coupons')
                ->onDelete('cascade');
            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_coupon_metas');
    }
}
