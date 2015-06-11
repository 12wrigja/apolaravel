<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_events', function(Blueprint $table)
		{
			$table->increments('id');
            $table->enum('service_type',['chapter','country','community','campus']);
            $table->string('location');
            $table->enum('project_type',['inside','outside']);
            $table->boolean('offCampus');
            $table->integer('travel_time');
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
		Schema::drop('service_events');
	}

}
