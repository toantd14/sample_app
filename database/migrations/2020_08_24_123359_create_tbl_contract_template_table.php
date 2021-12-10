<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblContractTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contract_template', function (Blueprint $table) {
            $table->bigIncrements('serial_no')->comment('シリアルNo');
            $table->text('use_terms')->nullable()->comment('契約書');
            $table->tinyInteger('del_flg')->nullable()->comment('削除フラグ');
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
        Schema::dropIfExists('tbl_contract_template');
    }
}
