<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToFieldsInCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields_in_checkout', function (Blueprint $table) {
            $table->string('cart_amount')->nullable()->change();
            $table->string('total_amount')->nullable()->change();
            $table->string('patient_firstname')->nullable()->change();
            $table->string('patient_lastname')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('shipping_method')->nullable()->change();
            $table->string('card_number')->nullable()->change();
            $table->string('card_name')->nullable()->change();
            $table->string('address_type')->nullable()->change();
            $table->string('pharmacy_detail')->nullable()->change();
            $table->string('medication_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('fields_in_checkout', function (Blueprint $table) {
            //
        });*/
    }
}
