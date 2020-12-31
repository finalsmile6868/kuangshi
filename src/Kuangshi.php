<?php

namespace Finalsmile6868\Kuangshi;

use Exception;
use Finalsmile6868\Kuangshi\Common\Sign;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Kuangshi
{
    const API_HOST = 'https://api-cloud9.megvii.com';
    const PERSON_LIST = '/v1/person/list'; //分页查询人员列表

    public function test()
    {
        return "<strong>...test...</strong>";
    }

    /**
     * 分页查询人员列表
     * type	integer	必须    人员类别：1-员工；2-访客；3-重点人
     * pageNum	integer	非必须		页码，从1开始，默认值1
     * pageSize	integer	非必须		页面大小，默认20，最大50
     */
    public function getPersonList($type = 1, $pageNum = 1, $pageSize = 20)
    {
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = $pageSize > 50 ? 50 : $pageSize;

        $reqParam = compact('type', 'pageNum', 'pageSize');

        $sign_data = Sign::getSign(self::PERSON_LIST, $reqParam);
        $result =  $this->sendRequest($reqParam, $sign_data);
        $result = json_decode($result, true);
        if($result['code']==0){
            return $result['data'];
        }else{
            throw new Exception($result['msg']);
        }       
    }

    public function sendRequest($reqParam, $sign_data)
    {
        $headers = $sign_data['headers'];
        $uri = $sign_data['uri'];

        $client = new Client(['base_uri' => self::API_HOST]);
        $options = [
            'json' => $sign_data['body_array'],
            'headers' => $headers,
        ];
        $response = $client->post($uri, $options);

        $contents = $response->getBody()->getContents();
        Log::useFiles(storage_path('logs/kuangshi.log'), 'info');
        Log::info('request_result',[
            'uri'=>$uri,
            'options'=>$options,
            'contents'=>$contents,
        ]);
        return $contents;
    }
}
