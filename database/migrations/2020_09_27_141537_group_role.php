<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('groups', function (Blueprint $table){
            $table->softDeletes();
        });

        Schema::create('groups_roles',  function (Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('role');
            $table->foreign('role')->references('id')->on('roles');

            $table->unsignedBigInteger('group');
            $table->foreign('group')->references('id')->on('groups');

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
