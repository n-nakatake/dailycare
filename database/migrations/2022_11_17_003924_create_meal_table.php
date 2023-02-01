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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resident_id'); // 利用者ID
            $table->integer('user_id'); // 記録者
            $table->dateTime('meal_time');   // 時間
            $table->string('meal_bld');      // 朝食、昼食、夜食
            $table->integer('meal_intake_rice')->nullable();    // 主食の摂取量
            $table->integer('meal_intake_side')->nullable();    // おかずの摂取量
            $table->integer('meal_intake_soup')->nullable();    // 汁物の摂取量
            $table->text('meal_note')->nullable();              // 特記
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
        Schema::dropIfExists('meals');
    }
};
