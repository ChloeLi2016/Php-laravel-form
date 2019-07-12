<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departmentDDA', function (Blueprint $table) {
            $table->string('dept_code',20);
			$table->string('comp',5);
			$table->string('div',5);
			$table->string('dept',5);
			$table->string('area',5);
			$table->timestamp('create_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('modified_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));;
			$table->string('last_update_id',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DepartmentDDA');
    }
}
