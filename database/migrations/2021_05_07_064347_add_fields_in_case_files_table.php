<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInCaseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->string('system_case_id')->after('mime_type');
            $table->string('system_file')->after('system_case_id');           
            $table->integer('user_id')->after('system_file');
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
