<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationReadedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_readeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader');
            $table->unsignedBigInteger('notification');
            $table->foreign('notification')->references('id')->on('notifications');
            $table->foreign('reader')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('notification_readeds');
    }
}
