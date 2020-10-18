<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Configuration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['text', 'number', 'date', 'time', 'datetime', 'boolean', 'image', 'color']);
            $table->string('text')->nullable();
            $table->double('number')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->boolean('boolean')->nullable();
            $table->unsignedBigInteger('image')->nullable();
            $table->foreign('image')->references('id')->on('image_files');
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
        //
    }
}
