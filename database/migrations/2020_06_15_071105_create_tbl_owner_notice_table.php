<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOwnerNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_owner_notice', function (Blueprint $table) {
            $table->increments('notics_cd')->comment('お知らせコード');
            $table->integer('member_cd')->comment('会員コード');
            $table->string('notics_title')->comment('タイトル');
            $table->text('notics_details')->comment('内容');
            $table->string('site_url')->comment('関連サイトURL');
            $table->tinyInteger('announce_period')->comment('告知期間');
            $table->string('registered_person', 50)->comment('登録者');
            $table->string('updater', 50)->comment('更新者');
            $table->timestamps();

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
        Schema::dropIfExists('tbl_owner_notice');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
