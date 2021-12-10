<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAdminNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_notice', function (Blueprint $table) {
            $table->increments('notics_cd');
            $table->string('notics_title', 100)->nullable();
            $table->string('notics_details')->nullable();
            $table->string('site_url', 100)->nullable();
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
        Schema::dropIfExists('tbl_admin_notice');
    }
}
