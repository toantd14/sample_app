<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contract', function (Blueprint $table) {
            $table->bigIncrements('serial_no')->comment('シリアルNo');
            $table->bigInteger('receipt_number')->nullable()->comment('受付コード');
            $table->text('use_terms')->nullable()->comment('契約書');
            $table->string('zip_cd',7)->nullable()->comment('所在地_郵便番号');
            $table->tinyInteger('prefectures_cd')->comment('所在地_都道府県');
            $table->string('municipality_name', 150)->comment('所在地_市区町村郡');
            $table->string('townname_address', 200)->comment('所在地_町域名＋番地');
            $table->string('building_name', 200)->nullable()->comment('所在地_建物');
            $table->string('tel_no',13)->comment('電話番号');
            $table->tinyInteger('del_flg')->nullable()->comment('削除フラグ');
            $table->string('registered_person', 50)->nullable()->comment('登録者');
            $table->string('updater', 50)->nullable()->comment('更新者');
            $table->string('contractor_name', 50)->nullable()->comment('契約者名');

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
        Schema::dropIfExists('tbl_contract');
    }
}
