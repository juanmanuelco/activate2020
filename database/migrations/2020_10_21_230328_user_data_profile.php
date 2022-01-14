<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDataProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->boolean('contact')->default(false)->after('name');
            $table->boolean('show_photo')->default(false)->after('contact');
            $table->boolean('show_name')->default(false)->after('show_photo');
            $table->boolean('show_phone')->default(false)->after('show_name');
            $table->boolean('show_location')->default(false)->after('show_phone');
            $table->boolean('show_age')->default(false)->after('show_location');
            $table->longText('photo')->nullable()->after('show_age');
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
