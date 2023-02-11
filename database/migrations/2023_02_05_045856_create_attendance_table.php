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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->dateTime('attendance_date');   // 出勤日
            $table->integer('user_id')->nullable(); // 常勤のユーザーID
            $table->string('part_time_member')->nullable(); // 非常勤の出勤者名
            $table->integer('attendance_type'); // 1:日勤,2:夜勤
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
        Schema::dropIfExists('attendances');
    }
};
