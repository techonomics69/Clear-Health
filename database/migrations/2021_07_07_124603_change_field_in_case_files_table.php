<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldInCaseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->string('case_id')->nullable()->change();
            $table->string('file')->nullable()->change();
            $table->string('md_file_name')->nullable()->change();
            $table->string('md_mime_type')->nullable()->change();
            $table->string('md_url')->nullable()->change();
            $table->string('md_file_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('case_files', function (Blueprint $table) {
            //
        });*/
    }
}
