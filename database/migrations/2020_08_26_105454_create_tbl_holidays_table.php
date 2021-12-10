<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_holidays', function (Blueprint $table) {
            $table->bigIncrements('serial_no')->comment('シリアルNo');
            $table->string('date', 10)->nullable();
            $table->string('comment', 100)->nullable();
            $table->string('registered_person', 50)->nullable()->comment('登録者');
            $table->string('updater', 50)->nullable()->comment('更新者');

            $table->softDeletes();
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
        Schema::dropIfExists('tbl_holidays');
    }
}
