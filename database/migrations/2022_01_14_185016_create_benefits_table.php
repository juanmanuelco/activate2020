<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('benefit');
            $table->text('restriction')->nullable();

            $table->integer('points')->default(0);
            $table->double('gains')->default(0);

            $table->boolean('unlimited')->default(false);

            $table->unsignedBigInteger('image')->nullable();
            $table->foreign('image')->references('id')->on('image_files');

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
        Schema::dropIfExists('benefits');
    }
}
