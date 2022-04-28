<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFileRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_file_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('document_revision_id', 20);
            $table->text('attachment');
            $table->text('attachment_mask');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_file_revisions');
    }
}
