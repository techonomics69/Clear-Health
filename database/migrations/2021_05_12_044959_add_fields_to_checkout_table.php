<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkout', function (Blueprint $table) {
            $table->string('order_detail_id')->nullable()->after('case_id');
            $table->string('md_case_id')->nullable()->after('order_detail_id');
            $table->string('md_status')->nullable()->after('md_case_id');
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
