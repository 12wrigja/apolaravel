<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayOrderToCarouselItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carousel_items',function(Blueprint $table){
            $table->integer('display_order')->default(0);
            $table->unique(array('event_id','display_order'));
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
            $table->dropUnique(array('event_id','display_order'));
            $table->dropColumn('display_order');
        });
    }
}
