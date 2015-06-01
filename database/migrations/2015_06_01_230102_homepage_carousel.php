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
            $table->char('background_image',400);
            $table->char('caption',500);
            $table->char('action_text',200);
            $table->char('action_url',500);
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
