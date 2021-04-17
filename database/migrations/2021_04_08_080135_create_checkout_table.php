<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('product_amount');
            $table->string('total_amount');
            $table->string('patient_firstname');
            $table->string('patient_lastname');
            $table->string('email');
            $table->string('shipping_method');
            $table->string('shipping_addreess_id')->nullable();
            $table->string('billing_address_id')->nullable();
            $table->string('card_number');
            $table->string('card_name');
            $table->enum('address_type', ['1', '2'])->comment = "1=shipping,2=billing";
            $table->string('pharmacy_detail');
            $table->enum('medication_type', ['1', '2'])->comment = "1=Prescribed,2=Non_Prescribed";
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
        Schema::dropIfExists('checkout');
    }
}
