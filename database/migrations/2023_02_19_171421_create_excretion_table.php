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
        Schema::create('excretions', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id'); // 事業所ID            
            $table->bigInteger('resident_id');     // 利用者ID
            $table->integer('user_id');            // 記録者
            $table->dateTime('excretion_time');   // 時間
            $table->smallInteger('excretion_flash')->default(false);   // 排尿有無
            $table->smallInteger('excretion_dump')->default(false);   // 排便有無
            $table->text('excretion_note')->nullable();   // 特記
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
        Schema::dropIfExists('excretions');
    }
};
