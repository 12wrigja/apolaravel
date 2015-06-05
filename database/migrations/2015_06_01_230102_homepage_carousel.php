<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HomepageCarousel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('homepage_carousel', function(Blueprint $table)
		{
			$table->increments('id');
            $table->char('title',140);
            $table->text('background_image',400);
            $table->text('caption',500)->nullable();
            $table->char('action_text',200)->nullable();
            $table->text('action_url',500)->nullable();
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
		Schema::drop('homepage_carousel');
	}

}
