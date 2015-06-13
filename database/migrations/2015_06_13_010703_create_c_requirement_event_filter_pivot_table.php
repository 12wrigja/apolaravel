<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCRequirementEventFilterPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_requirement_event_filter', function(Blueprint $table) {
            $table->integer('c_requirement_id')->unsigned()->index();
            $table->foreign('c_requirement_id')->references('id')->on('c_requirements')->onDelete('cascade');
            $table->integer('event_filter_id')->unsigned()->index();
            $table->foreign('event_filter_id')->references('id')->on('event_filters')->onDelete('cascade');
            $table->primary(['c_requirement_id','event_filter_id'],'c_requirement_event_filter_primary_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('c_requirement_event_filter');
    }
}
