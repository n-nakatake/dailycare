<?php

use App\Models\Office;
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
        Schema::table('offices', function (Blueprint $table) {
            $table->bigInteger('office_number')->change();
        });
        Office::insert([ // 初期データの投入
            ['office_number' => 4570101636, 'office_name' => 'グループホーム一喜一喜'],
            ['office_number' => 4570103152, 'office_name' => 'グループホーム楽楽'],
            ['office_number' => 4590100451, 'office_name' => 'グループホームさくら'],
            ['office_number' => 4570105447, 'office_name' => '有料老人ホームおおつかの杜'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->integer('office_number')->change();
        });
         // 初期データの削除
        Office::whereIn('office_number', [4570101636, 4570103152, 4590100451, 4570105447])->delete();
    }
};
