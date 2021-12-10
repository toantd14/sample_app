<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstQuestionCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_question_category', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 30)->nullable();
            $table->tinyInteger('del_flg')->default(0);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();
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
        Schema::dropIfExists('mst_question_category');
    }
}
