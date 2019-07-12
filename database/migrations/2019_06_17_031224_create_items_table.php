<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('itemNo',10)->unique();
			$table->index('itemNo');
			$table->string('description',70);
			$table->string('type', 30);
			$table->string('unit',5);
			$table->decimal('price',8,2);
			$table->string('supplier',20);
			$table->enum('gadOnly',['Y','N']);			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
