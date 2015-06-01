<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->char('login', 10);
            $table->char('first_name',50);
            $table->char('last_name',50);
            $table->char('nickname',50);
            $table->char('email');
            $table->char('phone_number');
            $table->char('address',500);
            $table->char('city',100);
            $table->char('state',20);
            $table->char('zipcode',15);
            $table->char('campus_residence');
            $table->integer('pledge_semester');
            $table->integer('initiation_semester');
            $table->integer('family_id');
            $table->char('big',10);
            $table->longtext('biography');
            $table->longText('join_reason');
            $table->char('major');
            $table->char('minor');
            $table->integer('grad_semester');
            $table->char('hometown');
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
		Schema::drop('members');
	}

}
