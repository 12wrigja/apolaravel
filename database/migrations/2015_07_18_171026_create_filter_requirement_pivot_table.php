<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterRequirementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_requirement', function(Blueprint $table) {
            $table->integer('filter_id')->unsigned()->index();
            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('cascade');
            $table->integer('requirement_id')->unsigned()->index();
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filter_requirement');
    }
}
