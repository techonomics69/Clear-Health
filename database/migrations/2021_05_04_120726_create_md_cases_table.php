<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_cases', function (Blueprint $table) {
            $table->id();
            $table->string('prioritized_at')->nullable();
            $table->string('prioritized_reason')->nullable();
            $table->string('cancelled_at')->nullable();
            $table->timestamp('md_created_at'); 
            $table->string('support_reason')->nullable();
            $table->string('case_id');
            $table->string('status');
            $table->string('user_id');
            $table->string('system_case_id');
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
        Schema::dropIfExists('md_cases');
    }
}
