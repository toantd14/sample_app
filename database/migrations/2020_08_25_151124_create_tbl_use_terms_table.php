<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUseTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_use_terms', function (Blueprint $table) {
            $table->bigIncrements('serial_no')->comment('シリアルNo');
            $table->text('use_terms')->nullable()->comment('利用規約');
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
        Schema::dropIfExists('tbl_use_terms');
    }
}
