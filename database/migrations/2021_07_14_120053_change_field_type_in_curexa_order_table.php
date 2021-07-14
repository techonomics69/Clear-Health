<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTypeInCurexaOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curexa_order', function (Blueprint $table) {
            $table->string('order_status')->nullable()->change();
            $table->string('status_details')->nullable()->change();
            $table->string('tracking_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curexa_order', function (Blueprint $table) {
            //
        });
    }
}
