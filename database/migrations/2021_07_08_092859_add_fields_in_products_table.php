<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longtext("section1_title")->after('section1')->nullable();
            $table->longtext("section1_content")->after('section1_title')->nullable();
            $table->longtext("section1_image")->after('section1_content')->nullable();
            $table->longtext("section2_title")->after('section2')->nullable();
            $table->longtext("section2_image")->after('section1_content')->nullable();
            $table->longtext("section2_content")->after('section2_title')->nullable();
            $table->longtext("section3_title")->after('section3')->nullable();
            $table->longtext("section3_content")->after('section3_title')->nullable();
            $table->longtext("section3_image")->after('section3_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('products', function (Blueprint $table) {
            //
        });*/
    }
}
