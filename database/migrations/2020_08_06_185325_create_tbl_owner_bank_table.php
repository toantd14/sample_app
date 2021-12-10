<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOwnerBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_owner_bank', function (Blueprint $table) {
            $table->bigInteger('owner_cd')->primary();
            $table->string('bank_cd', 4)->nullable();
            $table->string('bank_name', 150);
            $table->string('branch_cd', 5)->nullable();
            $table->string('branch_name', 150);
            $table->tinyInteger('account_type')->default(0);
            $table->string('account_name', 250);
            $table->string('account_kana', 300);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();

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
        Schema::dropIfExists('tbl_owner_bank');
    }
}
