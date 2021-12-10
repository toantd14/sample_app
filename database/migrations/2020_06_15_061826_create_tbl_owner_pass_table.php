<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOwnerPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_owner_pass', function (Blueprint $table) {
            $table->bigInteger('member_cd')->comment('会員コード');
            $table->string('pass', 255)->nullable()->comment('パスワード');
            $table->string('registered_person', 50)->nullable()->comment('登録者');
            $table->string('updater', 50)->nullable()->comment('更新者');
            $table->timestamps();

            $table->primary('member_cd');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('tbl_owner_pass');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
