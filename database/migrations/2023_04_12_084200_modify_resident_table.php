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
            $table->renameColumn('retirement_day', 'left_date');
            $table->renameColumn('retirement_note', 'leaving_note');
            $table->renameColumn('first_name_K', 'first_name_k');
            $table->renameColumn('key_person_adress', 'key_person_address');
            $table->dropColumn('level');
            $table->dropColumn('level_start');
            $table->dropColumn('level_end');
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
            $table->renameColumn('left_date', 'retirement_day');
            $table->renameColumn('leaving_note', 'retirement_note');
            $table->renameColumn('first_name_k', 'first_name_K');
            $table->renameColumn('key_person_address', 'key_person_adress');
            $table->string('level');
            $table->date('level_start');
            $table->date('level_end');
        });
    }
};
