<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Store extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('owner')->nullable();
            $table->foreign('owner')->references('id')->on('users');

            $table->unsignedBigInteger('image')->nullable();
            $table->foreign('image')->references('id')->on('image_files');

            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

            $table->string('web_page')->nullable();
            $table->string('phone')->nullable();


            $table->text('schedule')->nullable();

            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('categories');

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
