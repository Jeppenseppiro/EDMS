<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermitLicenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_license', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('effective_date', 20);
            $table->string('expiration_date', 20);
            $table->text('attachment');
            $table->text('attachment_mask');
            $table->string('file_password', 20);
            $table->text('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permit_license');
    }
}
