<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_receivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver')->nullable();
            $table->unsignedBigInteger('mail');
            $table->foreign('mail')->references('id')->on('mails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_receivers');
    }
}
