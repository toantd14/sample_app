<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_owner', function (Blueprint $table) {
            $table->bigInteger('owner_cd');
            $table->tinyInteger('kubun')->nullable();
            $table->string('name_c', 100)->nullable();
            $table->string('person_man', 50)->nullable();
            $table->string('department', 50)->nullable();
            $table->string('hp_url', 150)->nullable();;
            $table->string('mail_add', 150)->nullable();
            $table->string('zip_cd', 7)->nullable();
            $table->tinyInteger('prefectures_cd');
            $table->string('municipality_name', 150);
            $table->string('townname_address', 200);
            $table->string('building_name', 200)->nullable();
            $table->string('tel_no', 12)->nullable();
            $table->string('fax_no', 12)->nullable();
            $table->string('certification_cd', 4)->nullable();
            $table->tinyInteger('certification_result')->default(0)->nullable();
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();
            $table->tinyInteger('mgn_flg')->default(0);
            $table->timestamps();

            $table->primary('owner_cd');
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
        Schema::dropIfExists('tbl_owner');
    }
}
