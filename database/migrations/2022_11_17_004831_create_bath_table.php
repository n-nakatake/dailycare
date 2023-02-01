<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baths', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resident_id'); // 利用者ID
            $table->integer('user_id'); // 記録者
            $table->dateTime('bath_time');   // 時間
            $table->string('bath_method');   // 入浴方法
            $table->text('bath_note')->nullable();   // 特記
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
        Schema::dropIfExists('baths');
    }
};
