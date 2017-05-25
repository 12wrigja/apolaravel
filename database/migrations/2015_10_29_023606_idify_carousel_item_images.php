<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class IdifyCarouselItemImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carousel_items',function(Blueprint $table){
            $table->integer('background_image')->unsigned()->change();
            $table->foreign('background_image')->references('id')->on('image_entries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carousel_items',function(Blueprint $table){
            $table->dropForeign(['background_image']);
        });
        Schema::table('carousel_items',function(Blueprint $table){
            $table->string('background_image')->change();
        });
    }
}
