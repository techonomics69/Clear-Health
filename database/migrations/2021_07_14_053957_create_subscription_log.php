<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_log', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('case_id')->nullable();
            $table->string('md_case_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('subscr_id')->nullable();
            $table->string('customer')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('plan_amount')->nullable();
            $table->string('plan_currency')->nullable();
            $table->string('plan_interval')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('created')->nullable();
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
        Schema::dropIfExists('subscription_log');
    }
}
