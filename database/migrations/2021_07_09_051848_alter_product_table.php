<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('imp_info_title')->nullable()->after('detail');
            $table->string('imp_info_content')->nullable()->after('imp_info_title');
            $table->string('section1_button_show')->nullable()->after('imp_info_content');
            $table->string('section1_button_content')->nullable()->after('section1_button_show');
            $table->string('section2_button_show')->nullable()->after('section1_button_content');
            $table->string('section2_button_content')->nullable()->after('section2_button_show');
            $table->string('section3_button_show')->nullable()->after('section2_button_content');
            $table->string('section3_button_content')->nullable()->after('section3_button_show');
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
