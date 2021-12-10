<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToTblReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_review', function (Blueprint $table) {
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
        Schema::table('tbl_review', function (Blueprint $table) {
            $table->string('registered_person', 50)->change();
            $table->string('updater', 50)->change();
        });
    }
}
