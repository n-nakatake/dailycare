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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('baths', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('excretions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('meals', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('residents', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('vitals', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('baths', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('excretions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('meals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('residents', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('vitals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
