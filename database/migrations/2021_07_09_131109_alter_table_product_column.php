<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('imp_info_title')->nullable()->change();
            $table->text('imp_info_content')->nullable()->change();
            $table->text('section1_button_show')->nullable()->change();
            $table->text('section1_button_content')->nullable()->change();
            $table->text('section2_button_show')->nullable()->change();
            $table->text('section2_button_content')->nullable()->change();
            $table->text('section3_button_show')->nullable()->change();
            $table->text('section3_button_content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
