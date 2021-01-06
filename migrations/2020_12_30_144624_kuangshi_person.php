<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KuangshiPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuangshi_persons', function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->bigInteger('birthday')->nullable()->default(0)->comment('生日，时间戳，精确到毫秒，只有员工才有');
            $table->string('cardNum')->default('')->comment('卡号，只有员工才有');
            $table->string('code')->default('')->comment('员工编号，唯一');
            $table->string('departmentName')->default('')->comment('departmentName');
            $table->string('departmentUuid')->default('')->comment('部门UUID，只有员工才有');
            $table->string('email')->default('')->comment('邮箱，唯一');
            $table->bigInteger('entryTime')->default(0)->comment('入职时间，时间戳，精确到毫秒');
            $table->string('ext', 100)->default('')->comment('备注，只有员工才有');
            $table->string('groupList',500)->nullable()->comment('人员所属组列表');
            $table->string('groupName', 100)->default('')->comment('组名');
            $table->string('groupUuid', 100)->default('')->comment('组UUID');
            $table->string('identifyNum', 100)->default('')->comment('证件号');
            $table->string('imageUrl', 255)->default('')->comment('用户识别照片的url');
            $table->string('name', 100)->default('')->comment('人员姓名');
            $table->string('password', 100)->default('')->comment('密码，只有员工才有');
            $table->string('phone', 15)->default('')->comment('手机号，唯一');
            $table->string('position', 100)->default('')->comment('职位，只有员工才有');
            $table->tinyInteger('sex')->default(0)->comment('性别， 0-未知；1-男；2-女');
            $table->integer('type')->default(1)->comment('人员类别， 1-员工；2-访客；3-重点人员');
            $table->string('uuid')->comment('人员UUID');
            $table->bigInteger('visitEndTime')->default(0)->comment('拜访结束时间，时间戳，精确到毫秒，只有访客才有');
            $table->string('visitReason', 100)->default('')->comment('来访目的，只有访客才有');
            $table->bigInteger('visitStartTime')->default(0)->comment('拜访起始时间，时间戳，精确到毫秒，只有访客才有');
            $table->string('visitedName', 100)->default('')->comment('受访人的姓名，只有访客才有');
            $table->boolean('visitedStatus')->default(false)->comment('访客状态，true-有效；false-无效，只有访客才有');
            $table->bigInteger('visitedUuid')->default(0)->comment('受访人的UUID，只有访客才有');
            $table->softDeletes();            
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
        //
    }
}
