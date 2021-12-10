<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_admin', function (Blueprint $table) {
            $table->bigIncrements('serial_no');
            $table->string('name_sei', 50)->nullable();
            $table->string('name_mei', 50)->nullable();
            $table->string('login_mail', 50)->nullable();
            $table->string('passw', 250)->nullable();
            $table->integer('del_flg')->default(0); // 0: is data, 1: delete (data expired)
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
        Schema::dropIfExists('mst_admin');
    }
}
