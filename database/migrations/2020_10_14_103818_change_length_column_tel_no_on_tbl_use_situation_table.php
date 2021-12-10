<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLengthColumnTelNoOnTblUseSituationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_use_situation', function (Blueprint $table) {
            $table->string('tel_no', 15)->comment('連絡先')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_use_situation', function (Blueprint $table) {
            $table->string('tel_no', 12)->comment('連絡先')->nullable()->change();
        });
    }
}
