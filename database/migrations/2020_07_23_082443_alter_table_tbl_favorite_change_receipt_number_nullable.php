<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTblFavoriteChangeReceiptNumberNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_favorite', function (Blueprint $table) {
            $table->unsignedBigInteger('receipt_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_favorite', function (Blueprint $table) {
            $table->unsignedBigInteger('receipt_number')->nullable(false)->change();
        });
    }
}
