<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_name', 20);    // 性
            $table->string('first_name', 20);   // 名
            $table->string('last_name_k', 20);  // 性（フリガナ）
            $table->string('first_name_K', 20); // 名（フリガナ）
            $table->date('birthday');           // 誕生日
            $table->string('gender', 3);        // 性別
            $table->string('level');            // 介護度
            $table->date('level_start');        // 有効期間開始日
            $table->date('level_end');          // 有効期間終了日
            $table->string('key_person_name',30)->nullable();     // キーパーソン_名
            $table->string('key_person_relation')->nullable();    // キーパーソン_続∑柄
            $table->string('key_person_adress')->nullable();      // キーパーソン_住所
            $table->string('key_person_tel1')->nullable();        // キーパーソン_連絡先1
            $table->string('key_person_tel2')->nullable();        // キーパーソン_連絡先2
            $table->string('∑')->nullable();        // キーパーソン_メールアドレス
            $table->string('image_path')->nullable();  // 画像のパスを保存するカラム
            $table->text('note')->nullable();             // 特記
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
        Schema::dropIfExists('residents');
    }
};
