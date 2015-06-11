<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCEventCRequirementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_event_c_requirement', function(Blueprint $table) {
            $table->integer('c_event_id')->unsigned()->index();
            $table->foreign('c_event_id')->references('id')->on('c_events')->onDelete('cascade');
            $table->integer('c_requirement_id')->unsigned()->index();
            $table->foreign('c_requirement_id')->references('id')->on('c_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('c_event_c_requirement');
    }
}
