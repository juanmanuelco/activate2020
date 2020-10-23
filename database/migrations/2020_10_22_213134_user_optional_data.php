<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserOptionalData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->unsignedInteger('country')->nullable();
            $table->foreign('country')->references('id')->on('countries');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('addres1')->nullable();
            $table->string('addres2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('identification')->nullable();
            $table->enum('civil_state',['Soltero(a)', 'Casado(a)', 'Divorciado(a)', 'Viudo(a)' ])->default('Soltero(a)')->nullable();

            $table->boolean('show_gender')->default(false);
            $table->boolean('show_identification')->default(false);
            $table->boolean('show_civil_state')->default(false);

            $table->longText('about_me')->default('');
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
