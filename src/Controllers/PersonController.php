<?php

namespace Finalsmile6868\Kuangshi\Controllers;

use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Finalsmile6868\Kuangshi\Facades\Kuangshi;
use Finalsmile6868\Kuangshi\Jobs\KuangshiSyncData;
use Finalsmile6868\Kuangshi\Models\KuangshiPerson;
use Illuminate\Http\Request;

class PersonController extends AdminController{

    protected $title = '员工';

    // public function index(Request $request){
    //     // $data = Kuangshi::getPersonList();        
    //     // foreach($data as $item){
    //     //     $item['groupList'] = json_encode($item['groupList']);
    //     //     KuangshiPerson::create($item);
    //     // }
    //     $persons= KuangshiPerson::paginate(1);
    //     return view('kuangshi::person',['persons'=>$persons]);
    // }

    protected function grid(){     
        $grid = new Grid(new KuangshiPerson());
        $grid->model()->orderBy('id','desc');
        $grid->column('birthday','生日');
        $grid->column('cardNum','卡号');
        $grid->column('code','员工编号');
        $grid->column('sex','性别')->display(function($sex){
            if($sex == 0){
                return '未知';
            }elseif($sex == 1){
                return '男';
            }elseif($sex == 2){
                return '女';
            }
        });
        $grid->column('type','类型');
        $grid->column('phone','电话');
        $grid->column('imageUrl','照片')->image();
        $grid->column('name','姓名');
        $grid->column('identifyNum','证件号');
        $grid->column('email','邮箱');
        $grid->column('departmentName','部门名称');
        $grid->column('ext','备注');
        $grid->actions(function($actions){
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->disableCreateButton();

        $grid->tools(function ($tools) use ($grid) {
            $tools->append('<a class="btn btn-sm btn-facebook pull-right" id="sync_person"><i class="fa "></i>&nbsp;同步员工数据</a>&nbsp;');
        });            
        
        Admin::script('
            $("#sync_person").click(function(){
                $.ajax({
                    url:"sync-person",
                    dataType:"json",
                    async:true,
                    success:function(result){
                       
                    },
                    complete:function(result){
                     
                    }
                });
                alert("操作成功,请稍后刷新查看1");
            });
        ');

        return $grid;
    }

    public function sync(Request $request){

        KuangshiSyncData::dispatch(KuangshiPerson::TYPE_EMPLOYEE);
        return response()->json([
            'code'=>0,
            'msg'=>'操作成功，请稍后刷新查看',
        ], 200);
    }

}