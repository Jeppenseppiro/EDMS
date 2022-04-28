<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestIsoCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_iso_copies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user', 20);
            $table->string('date_request', 20);
            $table->string('document_library_id', 20);
            $table->string('copy_type', 20);
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
        Schema::dropIfExists('request_iso_copies');
    }
}
