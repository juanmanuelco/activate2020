<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CardStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_cards', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('card')->nullable();
            $table->foreign('card')->references('id')->on('cards');

            $table->unsignedBigInteger('store')->nullable();
            $table->foreign('store')->references('id')->on('stores');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
