<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_entries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->char('uploader',10);
            $table->foreign('uploader')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('free_use')->default(false);
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
        Schema::drop('image_entries');
    }
}
