<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_user', function (Blueprint $table) {
            $table->bigInteger('user_cd');
            $table->tinyInteger('howto_use')->default(null)->nullable();
            $table->string('facebook_id', 120)->nullable();
            $table->string('google_id', 120)->nullable();
            $table->string('line_id', 120)->nullable();
            $table->tinyInteger('user_kbn')->default(0);
            $table->string('name_sei', 50)->nullable();
            $table->string('name_mei', 50)->nullable();
            $table->string('corporate_name', 100)->nullable();
            $table->string('department', 50)->nullable();
            $table->string('person_man', 50)->nullable();
            $table->string('tel_no', 12)->nullable();
            $table->string('mail_add', 150)->nullable();
            $table->string('pass_word', 250)->nullable();
            $table->string('zip_cd', 7)->nullable();
            $table->tinyInteger('prefectures_cd');
            $table->string('municipality_name', 150);
            $table->string('townname_address', 200);
            $table->string('building_name', 200)->nullable();
            $table->string('token_key', 200)->nullable();
            $table->string('certification_cd', 4)->nullable();
            $table->tinyInteger('certification_result')->default(0);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->primary('user_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_user');
    }
}
