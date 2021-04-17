<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_address', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('checkout_id');
             $table->string('patient_firstname');
            $table->string('patient_lastname');
            $table->string('addressline1');
            $table->string('addressline2')->nullable();
            $table->string('city'); 
            $table->string('state'); 
            $table->string('zipcode');
            $table->string('email');
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('checkout_address');
    }
}
