<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalTable extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // title と body と image_path を追記
    public function up()
    {
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->integer('resident_id'); // 利用者ID
            $table->integer('user_id'); // 記録者
            $table->dateTime('vital_time');   // 時間
            $table->double('vital_kt',3,1)->nullable();   // 体温
            $table->integer('vital_bp_u')->nullable();    // 血圧（上）
            $table->integer('vital_bp_d')->nullable();    // 血圧（下）
            $table->integer('vital_hr')->nullable();      // 心拍数
            $table->double('vital_height',4,1)->nullable();   // 身長
            $table->double('vital_weight',4,1)->nullable();   // 体重
            $table->text('vital_note')->nullable();           // 特記
            $table->string('vital_image_path')->nullable();  // 画像のパスを保存するカラム
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
        Schema::dropIfExists('vitals');
    }
}