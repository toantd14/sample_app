<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnParkingCdToTblOwnerNotice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_owner_notice', function (Blueprint $table) {
            $table->bigInteger('parking_cd')->after('member_cd')->comment('駐車場管理コード')->nullable();
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
            $table->dropColumn('parking_cd');
        });
    }
}
