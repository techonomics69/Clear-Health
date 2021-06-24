<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInMdCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('md_cases', function (Blueprint $table) {
            $table->string('case_status_reason')->after('status')->nullable();
            $table->string('case_status_updated_at')->after('case_status_reason');
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
