<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestIsoEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_iso_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('date_request', 20);
            $table->text('requestor_name');
            $table->text('title');
            $table->string('proposed_effective_date', 20);
            $table->string('request_type', 20);
            $table->string('document_type', 20);
            $table->string('document_to_revise', 20);
            $table->text('document_purpose_request');
            $table->string('status', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_iso_entries');
    }
}
