<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_libraries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('requestor_name', 10);
            $table->text('description');
            $table->string('category', 10);
            $table->text('document_number_series');
            $table->string('tag', 10);
            $table->string('revision', 10);
            $table->string('attachment', 10);
            $table->string('control', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_libraries');
    }
}
