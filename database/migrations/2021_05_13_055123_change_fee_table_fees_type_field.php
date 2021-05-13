<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFeeTableFeesTypeField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->string('fee_type')->change()->comment = "
            minimum_shipping_amount=Minimum Shipping Amount,shipping_fee=Shipping Fee,topical=Topical,accutane=Accutane,topical_follow_up=Topical follow up,accutane_follow_up=Accutane follow up";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
