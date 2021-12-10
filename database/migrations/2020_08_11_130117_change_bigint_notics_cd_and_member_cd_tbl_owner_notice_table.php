<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBigintNoticsCdAndMemberCdTblOwnerNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_owner_notice', function (Blueprint $table) {
            $table->bigIncrements('notics_cd')->change();
            $table->bigInteger('member_cd')->change();
            $table->string('notics_title', 100)->nullable()->change();
            $table->string('notics_details')->nullable()->change();
            $table->string('site_url', 100)->nullable()->change();
            $table->string('registered_person', 50)->nullable()->change();
            $table->string('updater', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_owner_notice', function (Blueprint $table) {
            $table->increments('notics_cd');
            $table->integer('member_cd');
            $table->string('notics_title');
            $table->text('notics_details');
            $table->string('site_url');
        });
    }
}
