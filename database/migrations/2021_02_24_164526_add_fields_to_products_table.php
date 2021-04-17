<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {            
            $table->integer('status');
            $table->dateTime('available_date');           
            $table->bigInteger('category_id')->unsigned();
            $table->decimal('retails_price',8,2);            
            $table->integer('quantity');
            $table->integer('min_quantity_alert');
            $table->string('image');
            $table->string('url')->nullable();
            $table->decimal('price');
            $table->integer('weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
