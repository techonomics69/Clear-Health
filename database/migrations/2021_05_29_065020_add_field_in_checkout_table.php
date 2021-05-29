<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout', function (Blueprint $table) {
           $table->string('ipladege_id')->nullable()->after('plan_quantity');
           $table->string('delivery_date')->nullable()->after('ipladege_id');
           $table->string('md_status')->nullable()->after('delivery_date');
           $table->string('telemedicine_fee')->nullable()->after('md_status');
           $table->string('md_status')->nullable()->after('telemedicine_fee');
           $table->string('shipping_fee')->nullable()->after('md_status');
           $table->string('handling_fee')->nullable()->after('shipping_fee');
           $table->string('tax')->nullable()->after('handling_fee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('checkout', function (Blueprint $table) {
            //
        });*/
    }
}
