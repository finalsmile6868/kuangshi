<?php

namespace Finalsmile6868\Kuangshi\Controllers;

use App\Http\Controllers\Controller;
use Finalsmile6868\Kuangshi\Common\Sign;
use Finalsmile6868\Kuangshi\Events\KuangshiEvent;
use Finalsmile6868\Kuangshi\Models\KuangshiEventRecord as ModelsKuangshiEventRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifyController extends Controller
{

    public function index(Request $request)
    {
        try {            
            Log::info('kuangshi_notify', $request->all());

            // $response_json = '{"data":"测试数据","retryTimes":0,"traceId":"892e919f2f544b7ab1100a627da38a17","type":1}';
            // $cnonce = '957127';
            // $ctimestamp = '1609393793444';
            // $csign = '2904c7d6e80774d6b924c02af0c901f9';

            $cnonce = $request->header('cnonce')[0];
            $ctimestamp = $request->header('ctimestamp')[0];
            $csign = $request->header('csign')[0];
            $response_body = $request->all();
            // // $notify_data = json_decode($notify_data_json,true);
            // // dump($notify_data['data'][0]);
            //验证回调签名
            $check = Sign::notifyCheck(json_encode($response_body), $cnonce, $ctimestamp, $csign);
            if (!$check) {
                Log::warning('kuangshi:notify:error', [
                    'body' => $request->all(),
                    'header' => $request->header(),
                ]);
            }
            //判断是否同行回调通知
            if ($response_body['type'] == 2) {
                $record_data = $response_body['data'][0];
                if (key_exists('id', $record_data)) {
                    $record_data['record_id'] = $record_data['id'];
                    unset($record_data['id']);
                }
                //保存事件回调记录到数据库表
                $record = ModelsKuangshiEventRecord::create($record_data);
                //发送事件通知
                event(new KuangshiEvent($record));
            }

            echo true;
        } catch (\Exception $e) {
            echo false;
        }
    }
}
