<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldShipstationOrderIdInCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout', function (Blueprint $table) {
            $table->string('shipstation_order_id')->nullable()->after('transaction_complete_details');
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
