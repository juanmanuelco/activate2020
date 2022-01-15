<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->double('price', 8,2);

            $table->integer('start');
            $table->integer('end');

            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

            $table->integer('days')->default(0);
            $table->integer('points')->default(0);

            $table->unsignedBigInteger('image')->nullable();
            $table->foreign('image')->references('id')->on('image_files');

            $table->boolean('hidden')->default(false);

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
        Schema::dropIfExists('cards');
    }
}
