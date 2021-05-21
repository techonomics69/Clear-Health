<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsRecommendedProductSystemStatusMdCaseStatusToCaseManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_management', function (Blueprint $table) {
             $table->string('recommended_product')->nullable()->after('case_status');
             $table->string('system_status')->nullable()->after('recommended_product');
             $table->string('md_case_status')->nullable()->after('system_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('case_management', function (Blueprint $table) {
            //
        });*/
    }
}
