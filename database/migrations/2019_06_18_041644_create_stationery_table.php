<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationeryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationeryForm', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('RefNumber',20);
			$table->string('company',5);
			$table->string('division',5);
			$table->string('department',5);
			$table->string('area',5);
			$table->string('applier',15);
			$table->string('phone',15);
			$table->string('nextApprover',15);
			$table->json('items');
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
        Schema::dropIfExists('stationeryForm');
    }
}
