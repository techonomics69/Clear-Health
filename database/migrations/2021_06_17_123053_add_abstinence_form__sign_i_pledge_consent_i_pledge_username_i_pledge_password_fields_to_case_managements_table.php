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
            $table->string('abstinence_form')->after('follow_up')->default('0')->comment = '0=submited,1=not_submited';
            $table->string('sign_ipledge_consent')->after('abstinence_form')->default('0')->comment = '0=not_signed,1=signed';
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
