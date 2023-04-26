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
        Schema::create('care_certifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resident_id'); // 利用者ID
            $table->smallInteger('level'); // 介護度
            $table->dateTime('start_date')->nullable(); // 介護認定の有効開始日
            $table->dateTime('end_date')->nullable(); // 介護認定の有効終了日
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
        Schema::dropIfExists('care_certifications');
    }
};
