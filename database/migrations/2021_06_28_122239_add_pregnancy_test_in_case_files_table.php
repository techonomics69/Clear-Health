<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPregnancyTestInCaseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_files', function (Blueprint $table) {
              $table->string('test_verify')->default('0')->after('user_id')->comment = '0=pending,1=verified';
            $table->datetime('test_verify_at')->after('test_verify')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_files', function (Blueprint $table) {
            //
        });
    }
}
