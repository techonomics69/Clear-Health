<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPregnancyTestInMdCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('md_cases', function (Blueprint $table) {
            $table->string('pregnancy_test')->default('0')->after('case_type')->comment = '0=pending,1=verified';
            $table->datetime('pregnancy_test_verify_at')->after('pregnancy_test')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('md_cases', function (Blueprint $table) {
            //
        });
    }
}
