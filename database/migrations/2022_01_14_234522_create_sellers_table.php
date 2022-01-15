<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->double('commission')->default(0);
            $table->double('gains', 8,2)->default(0);


            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');

            $table->unsignedBigInteger('superior')->nullable();
            $table->foreign('superior')->references('id')->on('users');

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
        Schema::dropIfExists('sellers');
    }
}
