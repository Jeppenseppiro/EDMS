<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestLegalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_legal_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('date_request', 20);
            $table->text('requestor_name');
            $table->string('document_type', 20);
            $table->text('attachment');
            $table->string('status', 20);
            $table->text('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_legal_entries');
    }
}
