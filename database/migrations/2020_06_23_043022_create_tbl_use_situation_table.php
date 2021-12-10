<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUseSituationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_use_situation', function (Blueprint $table) {
            $table->bigIncrements('receipt_number')->comment('受付コード');
            $table->bigInteger('user_cd')->comment('利用者コード')->nullable();
            $table->bigInteger('owner_cd')->comment('オーナーコード')->nullable();
            $table->unsignedBigInteger('parking_cd')->comment('駐車場管理コード')->nullable();
            $table->unsignedBigInteger('parking_spacecd')->comment('駐車スペースコード')->nullable();
            $table->integer('parking_menucd')->comment('駐車メニューコード')->nullable();
            $table->tinyInteger('visit_no')->comment('メニュー区分')->nullable();
            $table->tinyInteger('reservation_use_kbn')->default(null)->comment('予約/利用区分')->nullable();
            $table->string('contract_id')->comment('契約書ID')->nullable();
            $table->string('reservation_day', 10)->comment('予約日（利用開始日）, format: yyyy/mm/dd')->nullable();
            $table->string('use_day', 10)->comment('利用日, format: yyyy/mm/dd')->nullable();
            $table->char('from_reservation_time', 5)->comment('予約時間　From, format: hh:mm')->nullable();
            $table->char('to_reservation_time', 5)->comment('予約時間　To, format: hh:mm')->nullable();
            $table->char('putin_time', 5)->comment('入庫予定時間, format: hh:mm')->nullable();
            $table->char('putout_time', 5)->comment('入庫予定時間, format: hh:mm')->nullable();
            $table->string('start_day', 10)->default(null)->comment('利用開始日')->nullable();
            $table->string('end_day', 10)->default(null)->comment('利用開始日')->nullable();
            $table->tinyInteger('period_month')->comment('利用期間（ヶ月）')->nullable();
            $table->string('usetime_from', 5)->comment('利用時間From')->nullable();
            $table->string('usetime_to', 5)->comment('利用時間From')->nullable();
            $table->string('car_type_reservation', 50)->comment('予約車種')->nullable();
            $table->string('car_no_reservation', 10)->comment('予約車番')->nullable();
            $table->string('car_type_performance', 50)->comment('実績車種')->nullable();
            $table->string('car_no_performance', 10)->comment('実績車番')->nullable();
            $table->string('space_symbol', 5)->comment('予約スペース記号')->nullable();
            $table->string('space_no', 5)->comment('予約スペース番号')->nullable();
            $table->tinyInteger('division')->default(0)->comment('申込区分')->nullable();
            $table->string('name_sei', 30)->comment('申込者名（姓）')->nullable();
            $table->string('name_mei', 30)->comment('申込者名（名)')->nullable();
            $table->string('name_seikana', 30)->comment('申込者名（名) カナ')->nullable();
            $table->string('name_meikana', 30)->comment('申込者名（名) カナ')->nullable();
            $table->string('company_name', 100)->comment('法人名')->nullable();
            $table->string('department', 50)->comment('部署名')->nullable();
            $table->string('person_man', 50)->comment('担当者名')->nullable();
            $table->string('tel_no', 12)->comment('連絡先')->nullable();
            $table->tinyInteger('payment_division_reservation')->default(null)->comment('予約支払方法')->nullable();
            $table->tinyInteger('payment_division')->default(null)->comment('支払方法')->nullable();
            $table->integer('money_reservation')->comment('予約支払金額')->nullable();
            $table->tinyInteger('conveni')->default(null)->comment('選択コンビニ')->nullable();
            $table->string('conveni_paymentno')->default(null)->comment('コンビニ払込番号')->nullable();
            $table->tinyInteger('combined_division')->default(0)->comment('支払_ポイント併用区分')->nullable();
            $table->string('settlement_id', 50)->comment('クレジット決済ID')->nullable();
            $table->string('conveni_day', 10)->comment('コンビニ支払日')->nullable();
            $table->integer('parking_fee')->comment('駐車料金')->nullable();
            $table->integer('discount_rates')->comment('割引料金')->nullable();
            $table->integer('combined_point')->comment('併用ポイント')->nullable();
            $table->integer('payment')->comment('支払金額')->nullable();
            $table->integer('grant_points')->comment('付与ポイント')->nullable();
            $table->string('payment_day', 10)->comment('入金日, format: yyyy/mm/dd')->nullable();
            $table->string('registered_person', 50)->comment('登録者')->nullable();
            $table->string('updater', 50)->comment('更新者')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_cd')->references('owner_cd')->on('tbl_owner');
            $table->foreign('parking_cd')->references('parking_cd')->on('tbl_parking_lot');
            $table->foreign('parking_spacecd')->references('serial_no')->on('tbl_parking_space');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('tbl_use_situation');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
