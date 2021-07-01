<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnsToCaseManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_managements', function (Blueprint $table) {
            $table->string('bloodwork_date')->after('bloodwork')->nullable();
            $table->string('prior_auth_date')->after('prior_auth')->nullable();
            $table->string('verify_prior_auth')->after('prior_auth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_managements', function (Blueprint $table) {
            //
        });
    }
}
