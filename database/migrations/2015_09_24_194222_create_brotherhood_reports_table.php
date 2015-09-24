<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateBrotherhoodReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brotherhood_reports', function(Blueprint $table) {
            $table->increments('id');
            $table->char('creator_id',10);
            $table->char('event_name');
            $table->longText('description');
            $table-> date('event_date');
            $table->string('location');
            $table->enum('type',['fellowship','pledge','other']);
            $table->boolean('approved')->default(false);
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
        Schema::drop('brotherhood_reports');
    }
}
