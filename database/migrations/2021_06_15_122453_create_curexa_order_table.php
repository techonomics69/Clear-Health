<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurexaOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curexa_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('rx_item_count');
            $table->string('otc_item_count');
            $table->string('status');
            $table->string('message');
            $table->string('order_status');
            $table->text('status_details');
            $table->string('tracking_number');
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
        Schema::dropIfExists('curexa_order');
    }
}
