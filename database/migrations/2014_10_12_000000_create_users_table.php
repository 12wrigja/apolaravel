<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->char('id', 10);
            $table->char('first_name',50)->nullable();
            $table->char('last_name',50)->nullable();
            $table->char('nickname',50)->nullable();
            $table->char('email')->nullable();
            $table->char('phone_number')->nullable();
            $table->text('address',500)->nullable();
            $table->char('city',100)->nullable();
            $table->char('state',20)->nullable();
            $table->char('zip_code',15)->nullable();
            $table->char('campus_residence')->nullable();
            $table->integer('pledge_semester')->nullable();
            $table->integer('initiation_semester')->nullable();
            $table->integer('family_id')->nullable();
            $table->char('big',10)->nullable();
            $table->longtext('biography')->nullable();
            $table->longText('join_reason')->nullable();
            $table->char('major')->nullable();
            $table->char('minor')->nullable();
            $table->integer('graduation_semester')->nullable();
            $table->char('hometown')->nullable();
            $table->timestamps();
            $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
