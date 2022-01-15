<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seller')->nullable();
            $table->foreign('seller')->references('id')->on('sellers');

            $table->unsignedBigInteger('card');
            $table->foreign('card')->references('id')->on('cards');

            $table->integer('number');
            $table->string('code');
            $table->enum('type', ['web', 'mobile', 'physical', 'gift'])->default('web');
            $table->string('email')->nullable();
            $table->double('price', 8,2)->nullable();
            $table->dateTimeTz('start')->nullable();
            $table->dateTimeTz('end')->nullable();
            $table->dateTimeTz('sale_date')->nullable();

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
        Schema::dropIfExists('assignments');
    }
}
