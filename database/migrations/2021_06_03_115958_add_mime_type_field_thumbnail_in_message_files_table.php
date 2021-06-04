<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMimeTypeFieldThumbnailInMessageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_files', function (Blueprint $table) {
            $table->string('mime_type')->nullable()->after('file_name');
             $table->string('thumbnail')->nullable()->after('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_files', function (Blueprint $table) {
            //
        });
    }
}
