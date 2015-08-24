<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrotherhoodReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brotherhood_events', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('location');
            $table->enum('type',['fellowship','pledge','other']);
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
		Schema::drop('brotherhood_events');
	}

}
