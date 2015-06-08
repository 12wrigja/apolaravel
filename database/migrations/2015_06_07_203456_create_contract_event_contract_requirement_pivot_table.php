<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContract_eventContract_requirementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_event_contract_requirement', function(Blueprint $table) {
            $table->integer('contract_event_id')->unsigned()->index();
            $table->foreign('contract_event_id')->references('id')->on('contract_event')->onDelete('cascade');
            $table->integer('contract_requirement_id')->unsigned()->index();
            $table->foreign('contract_requirement_id')->references('id')->on('contract_requirement')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_event_contract_requirement');
    }
}
