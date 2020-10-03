<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableBuilder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //\Illuminate\Support\Facades\DB::statement("ALTER TABLE builders DROP COLUMN page");
        Schema::table('builders', function (Blueprint $table){
            $table->string('session')->nullable();
            $table->longText('gjs-html')->nullable()->after('slug');
            $table->longText('gjs-components')->nullable()->after('gjs-html');
            $table->longText('gjs-assets')->nullable()->after('gjs-components');
            $table->longText('gjs-css')->nullable()->after('gjs-assets');
            $table->longText('gjs-styles')->nullable()->after('gjs-css');
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
