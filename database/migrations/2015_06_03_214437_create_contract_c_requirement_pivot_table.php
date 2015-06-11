R<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractCRequirementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_c_requirement', function(Blueprint $table) {
            $table->integer('contract_id')->unsigned()->index();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->integer('c_requirement_id')->unsigned()->index();
            $table->foreign('c_requirement_id')->references('id')->on('c_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_c_requirement');
    }
}
