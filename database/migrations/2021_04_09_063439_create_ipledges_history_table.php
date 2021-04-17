<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpledgesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipledges_history', function (Blueprint $table) {
            $table->id();
            $table->string('files');
            $table->enum('patients_type', ['0','1'])->comment = "'0'='Can Not Pregnant','1'='Can Pregnant'";
            $table->string('user_case_id')->nullable();
            $table->string('imported_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipledges_history');
    }
}
