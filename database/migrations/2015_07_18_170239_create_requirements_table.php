<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function(Blueprint $table) {
            $table->increments('id');
            $table->char('display_name');
            $table->longText('description');
            $table->integer('threshold');
            $table->enum('comparison',['LT','LEQ','EQ','GEQ','GT']);
            $table->text('compute_function');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('requirements');
    }
}
