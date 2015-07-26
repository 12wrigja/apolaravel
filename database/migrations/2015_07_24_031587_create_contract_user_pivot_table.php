<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_user', function(Blueprint $table) {
            $table->integer('contract_id')->unsigned()->index();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->char('user_id',10)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('semester_id')->unsigned()->index();
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_user');
    }
}
