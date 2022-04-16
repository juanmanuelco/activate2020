<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->double('subtotal', 8,2)->default(0);
            $table->double('discount', 8,2)->default(0);
            $table->double('total')->default(0);
            $table->timestamps();
        });
        Schema::create('billing_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('image')->nullable();
            $table->foreign('image')->references('id')->on('image_files');

            $table->unsignedBigInteger('billing')->nullable();
            $table->foreign('billing')->references('id')->on('billing');

            $table->string('code');
            $table->double('price', 8,2);
            $table->integer('quantity');

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
