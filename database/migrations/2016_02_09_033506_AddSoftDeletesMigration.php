<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports',function(Blueprint $table){
            $table->softDeletes();
        });
        Schema::table('brotherhood_reports',function(Blueprint $table){
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
        Schema::table('reports',function(Blueprint $table){
            $table->removeColumn('deleted_at');
        });
        Schema::table('brotherhood_reports',function(Blueprint $table){
            $table->removeColumn('deleted_at');
        });
    }
}
