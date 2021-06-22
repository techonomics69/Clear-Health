<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('case_id');
            $table->string('md_case_id');
            $table->string('subscr_id');
            $table->string('customer');
            $table->string('plan_id');
            $table->string('plan_amount');
            $table->string('plan_currency');
            $table->string('plan_interval');
            $table->string('plan_interval_count');
            $table->string('created');
            $table->string('current_period_start');
            $table->string('current_period_end');
            $table->string('status');
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
        Schema::dropIfExists('subscription');
    }
}
