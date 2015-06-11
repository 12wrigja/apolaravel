<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CEvents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('c_events', function(Blueprint $table)
		{
			$table->increments('id');
            $table->char('display_name');
            $table->longText('description');
            $table->date('event_date');
            $table->morphs('event_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('c_events');
	}

}
