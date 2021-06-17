<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbstinenceFormSignIPledgeConsentIPledgeUsernameIPledgePasswordFieldsToCaseManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_managements', function (Blueprint $table) {
            $table->string('abstinence_form')->nullable()->after('follow_up');
            $table->string('sign_ipledge_consent')->nullable()->after('abstinence_form');
            $table->string('ipledge_username')->nullable()->after('sign_ipledge_consent');
            $table->string('ipledge_password')->nullable()->after('ipledge_username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('case_managements', function (Blueprint $table) {
            //
        });*/
    }
}
