<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CRequirements extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('c_requirements', function(Blueprint $table)
		{
			$table->increments('id');
            $table->char('display_name');
            $table->longText('description');
            $table->integer('threshold');
            $table->enum('comparison',['LT','LEQ','EQ','GEQ','GT']);
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
		Schema::drop('c_requirements');
	}

}
