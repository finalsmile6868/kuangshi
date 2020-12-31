<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KuangshiEventRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuangshi_event_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            //****同行记录字段开始****
            $table->string('custom')->default('')->comment('扩展字段');
            $table->string('deviceLocation')->default('')->comment('设备地址(该字段是历史记录，不会实时更新）');
            $table->string('deviceName')->default('')->comment('设备名称(该字段是历史记录，不会实时更新）');
            $table->string('deviceUuid')->default('')->comment('设备uuid');
            $table->bigInteger('record_id')->default(0)->comment('对应返回的id字段');
            $table->double('livenessScore')->default(0)->comment('活体分数');
            $table->tinyInteger('livenessType')->default(1)->comment('活体结果 0：非活体攻击；1：活体');
            $table->tinyInteger('maskType')->default(0)->comment('口罩状态，0：未检测，1:已佩戴，2：未佩戴口罩');
            $table->bigInteger('passTime')->default(0)->comment('通行时间 (单位时间戳，精确毫秒)');
            $table->tinyInteger('passType')->default(0)->comment('通行类型 0：未通行；1：通行;2:复合认证未通过');
            $table->string('personCode')->default('')->comment('员工编号');
            $table->string('personImageUrl')->default('')->comment('底库照片(有效期一周)');
            $table->string('personName')->default('')->comment('人员名称(该字段是历史记录，不会实时更新）');
            $table->tinyInteger('personType')->default(1)->comment('员工类型(1:员工，2:访客，3:重点人员)');
            $table->string('personUuid')->default('')->comment('人员uuid');
            $table->double('recognitionScore')->default(0)->comment('识别分数');

            $table->tinyInteger('recognitionType')->default(1)->comment('识别类型 1：员工；2：访客；3：重点人员；4：陌生人；5：未识别');
            $table->string('snCode')->default('')->comment('snCode');
            $table->string('snapshotUrl')->default('')->comment('抓拍照片url，有效期一周');
            $table->double('temperature')->default(0)->comment('体温值');
            $table->tinyInteger('temperatureType')->default(0)->comment('体温状态，0：未检测，1：正常，2：高温');
            $table->tinyInteger('verificationMode')->default(0)->comment('验证类型 0：人脸；1：人脸或刷卡；2：人脸及刷卡；3：人脸及密码，4:远程开门，5:二维码');
            //****通行记录字段结束****
            $table->tinyInteger('type')->default(2)->comment('时间类型：1--测试数据 2--通行记录 4--设备事件 8--人员事件');
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
        Schema::dropIfExists('kuangshi_event_records');;
    }
}
