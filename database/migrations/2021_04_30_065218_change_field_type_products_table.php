<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTypeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
        $table->float('retails_price',52,2)->change();            
        $table->bigInteger('quantity')->change(); 
        $table->bigInteger('min_quantity_alert')->change(); 
        $table->float('price',53,2)->change(); 
        $table->bigInteger('weight')->change(); 
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
