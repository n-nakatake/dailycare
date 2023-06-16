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
        Schema::table('residents', function (Blueprint $table) {
            $table->text('key_person_address')->change();
            $table->text('key_person_tel1')->change();
            $table->text('key_person_tel2')->change();
            $table->text('key_person_mail')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('key_person_address')->change();
            $table->string('key_person_tel1')->change();
            $table->string('key_person_tel2')->change();
            $table->string('key_person_mail')->change();
        });
    }
};
