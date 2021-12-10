<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLengthColumnTelNoAndFaxNoOnTblOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_owner', function (Blueprint $table) {
            $table->string('tel_no', 15)->nullable()->change();
            $table->string('fax_no', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_owner', function (Blueprint $table) {
            $table->string('tel_no', 12)->nullable()->change();
            $table->string('fax_no', 12)->nullable()->change();
        });
    }
}
