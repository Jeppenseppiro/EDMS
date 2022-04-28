<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestCopyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_copy_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('request_copy_id', 10);
            $table->text('remarks');
            $table->string('status', 10);
            $table->string('tag', 10);
            $table->string('user', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_copy_histories');
    }
}
