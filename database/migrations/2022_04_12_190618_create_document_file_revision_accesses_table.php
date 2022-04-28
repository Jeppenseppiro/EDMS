<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFileRevisionAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_file_revision_accesses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('document_file_revision_id', 20);
            $table->string('user_access', 20);
            $table->string('user', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_file_revision_accesses');
    }
}
