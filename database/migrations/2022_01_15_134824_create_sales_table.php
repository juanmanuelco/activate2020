<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('seller')->nullable();
            $table->foreign('seller')->references('id')->on('sellers');

            $table->unsignedBigInteger('assignment');
            $table->foreign('assignment')->references('id')->on('assignments');

            $table->double('payment',8,2)->default(0);
            $table->boolean('paid')->default(false);

            $table->dateTimeTz('payment_date')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
