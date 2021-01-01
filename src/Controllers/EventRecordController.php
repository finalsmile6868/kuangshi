<?php

namespace Finalsmile6868\Kuangshi\Controllers;

use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Finalsmile6868\Kuangshi\Facades\Kuangshi;
use Finalsmile6868\Kuangshi\Jobs\KuangshiSyncData;
use Finalsmile6868\Kuangshi\Models\KuangshiEventRecord;
use Finalsmile6868\Kuangshi\Models\KuangshiPerson;
use Illuminate\Http\Request;

class EventRecordController extends AdminController
{

    protected $title = '事件记录';

    // public function index(Request $request){
    //     // $data = Kuangshi::getPersonList();        
    //     // foreach($data as $item){
    //     //     $item['groupList'] = json_encode($item['groupList']);
    //     //     KuangshiPerson::create($item);
    //     // }
    //     $persons= KuangshiPerson::paginate(1);
    //     return view('kuangshi::person',['persons'=>$persons]);
    // }

    protected function grid()
    {
        $grid = new Grid(new KuangshiEventRecord());
        $grid->column('deviceLocation', '设备地址');
        $grid->column('deviceName', '设备名称');
        $grid->column('deviceUuid', '设备uuid');
        $grid->column('livenessScore', '活体分数');
        $grid->column('livenessType', '活体结果')->display(function ($value) {
            if ($value == 0) {
                return '非活体攻击';
            } elseif ($value == 1) {
                return '活体';
            }
        });
        $grid->column('maskType', '口罩状态'); //0：未检测，1:已佩戴，2：未佩戴口罩
        $grid->column('passTime', '通行时间');
        $grid->column('passType', '通行类型'); // 0：未通行；1：通行;2:复合认证未通过
        $grid->column('personCode', '员工编号');
        $grid->column('personImageUrl', '底库照片')->image();
        $grid->column('personName', '人员名称');
        $grid->column('personType', '员工类型'); //(1:员工，2:访客，3:重点人员)
        $grid->column('personUuid', '人员uuid'); //
        $grid->column('recognitionType', ''); //识别类型 1：员工；2：访客；3：重点人员；4：陌生人；5：未识别
        $grid->column('snCode', '设备sn码'); //
        $grid->column('snapshotUrl', '抓拍照片')->image(); //
        $grid->column('temperature', '体温值'); //
        $grid->column('temperatureType', '体温状态')->display(function ($value) {
            if ($value == 0) {
                return '未检测';
            } elseif ($value == 1) {
                return '正常';
            } elseif ($value == 2) {
                return '高温';
            }
        }); //，0：未检测，1：正常，2：高温
        $grid->column('verificationMode', '验证类型')->display(function ($value) {
            if ($value == 0) {
                return '人脸';
            } elseif ($value == 1) {
                return '人脸或刷卡';
            } elseif ($value == 2) {
                return '人脸及刷卡';
            } elseif ($value == 3) {
                return '人脸及密码';
            } elseif ($value == 4) {
                return '远程开门';
            } elseif ($value == 5) {
                return '二维码';
            }
        }); // 0：人脸；1：人脸或刷卡；2：人脸及刷卡；3：人脸及密码，4:远程开门，5:二维码


        return $grid;
    }

    public function sync(Request $request)
    {

        KuangshiSyncData::dispatch(KuangshiPerson::TYPE_EMPLOYEE);
        return response()->json([
            'code' => 0,
            'msg' => '操作成功，请稍后刷新查看',
        ], 200);
    }
}
