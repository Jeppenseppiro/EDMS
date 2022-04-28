<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtransmittalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etransmittal', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user', 20);
            $table->text('item');
            $table->string('recipient', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etransmittal');
    }
}
