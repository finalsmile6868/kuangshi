<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToKuangshiPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuangshi_persons', function (Blueprint $table) {
            $table->bigInteger('user_id')->comment('用户Id');
            $table->tinyInteger('user_type')->default(2)->comment('1--学生，2--教师');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kuangshi_persons', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('user_type');
        }); 
    }
}
