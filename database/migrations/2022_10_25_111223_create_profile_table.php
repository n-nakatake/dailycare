<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resident_last_name', 20);    // 性
            $table->string('resident_first_name', 20);   // 名
            $table->string('resident_last_name_k', 20);  // 性（フリガナ）
            $table->string('resident_first_name_K', 20); // 名（フリガナ）
            $table->date('resident_birthday');           // 誕生日
            $table->string('resident_gender', 3);        // 性別
            $table->string('resident_level');            // 介護度
            $table->date('resident_level_start');        // 有効期間開始日
            $table->date('resident_level_end');          // 有効期間終了日
            $table->string('key_person_name',30);     // キーパーソン_名
            $table->string('key_person_relation');    // キーパーソン_続柄
            $table->string('key_person_adress');      // キーパーソン_住所
            $table->string('key_person_tel1');        // キーパーソン_連絡先1
            $table->string('key_person_tel2');        // キーパーソン_連絡先2
            $table->string('key_person_mail');        // キーパーソン_メールアドレス
            $table->string('image_path')->nullable();  // 画像のパスを保存するカラム
            $table->date('resident_note');             // 特記
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
        Schema::dropIfExists('profiles');
    }
};
