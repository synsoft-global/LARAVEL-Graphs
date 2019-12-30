<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('layout_id');
            $table->text('items')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('cascade');
            $table->timestamps();
            $table->index('layout_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layout_items');
    }
}
