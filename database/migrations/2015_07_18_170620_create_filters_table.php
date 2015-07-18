<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function(Blueprint $table) {
            $table->increments('id');
            $table->char('display_name');
            $table->longText('description');
            $table->string('controller');
            $table->string('method');
            $table->integer('requirement_id')->unsigned()->index();
            $table->foreign('requirement_id')->references('id')->on('requirements');
            $table->softdeletes();
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
        Schema::drop('filters');
    }
}
