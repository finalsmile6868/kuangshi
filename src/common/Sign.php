<?php

namespace Finalsmile6868\Kuangshi\Common;

use Exception;
use Illuminate\Support\Facades\Log;

class Sign
{

    /**
     * sign计算涉及以下数据：
     * 接口调用说明地址：https://cloud9.megvii.com/docs/web/part8/1.html#%E6%8E%A5%E5%8F%A3%E8%B0%83%E7%94%A8%E8%AF%B4%E6%98%8E
     * A：请求URI，以/开头，如/openapi/v1/pass/record/list
     * D：请求的requestbody中的内容的MD5(32位小写，下同)，如无内容，则为"{}"【注，对于文件上传类url，该字段用空字符串""替代】
     * E：cappkey对应的秘钥，即九霄平台分配的SecretKey
     * F：header中的ctimestamp、cnonce、cappkey
     * 签名算法：MD5，32位小写
     *
     * sign计算方法如下：
     *
     * 1）csign = MD5(A-D-E-ctimestamp-cnonce-cappkey)
     * 2）示例：
     *          A="/openapi/v1/pass/record/list"
     *          D="xxxdfefefsgsgsdfs"
     *          E="secret123"
     *          ctimestamp="1234567890"
     *          cnonce="123456"
     *          cappkey="appkey1xx"
     *
     * @param requestURI    请求URI               对应A
     * @param reqParamArray  请求参数的数组形式，如果是文件上传，传 null 或者 ""；没有参数，则传[] 对应D
     * @param secretKey     分配的secretKey        对应E
     * @param ctimestamp    Unix时间戳，精确到毫秒
     * @param cnonce        随机数
     * @param cappkey       分配给企业的appKey
     *
     * @return
     */
    public static function getSign($requestURI, $reqParamArray)
    {
        if (self::is_empty($requestURI)) {
            throw new Exception("参数错误，requestURI不能为空或者空字符串");
        } else {
            if (strpos($requestURI, '/openapi/') !== 0) {
                $requestURI = '/openapi' . $requestURI;
            }
        }

        $secretKey = config('kuangshi.SecretKey');
        $cappkey = config('kuangshi.AppKey');

        if (self::is_empty($cappkey)) {
            throw new Exception("参数错误，appKey不能为空或者空字符串");
        }
        if (self::is_empty($secretKey)) {
            throw new Exception("参数错误，secretKey不能为空或者空字符串");
        }

        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $ctimestamp = substr($msectime, 0, 13);
        // if (self::is_empty($ctimestamp) || !is_numeric($ctimestamp)) {
        //     throw new Exception("参数错误，ctimestamp不能为空或者空字符串，且必须为数字");
        // }
        //生成6位随机数
        $cnonce = substr(bin2hex(random_bytes(6)), 0, 6);
        // if (self::is_empty($cnonce)) {
        //     throw new Exception("参数错误，cnonce都不能为空或者空字符串");
        // }

        if (is_array($reqParamArray)) {
            if (empty($reqParamArray)) {
                $reqParamJson = '';
                $requestBodyMD5 = '{}';
            } else {
                $reqParamJson = json_encode($reqParamArray);
                $requestBodyMD5 = self::encrypt_md5($reqParamJson);
            }
        } else {
            $reqParamJson = '';
            $requestBodyMD5 = '';
        }


        $csign = sprintf('%s-%s-%s-%d-%s-%s', $requestURI, $requestBodyMD5, $secretKey, $ctimestamp, $cnonce, $cappkey);
        $sign = md5($csign);

        Log::useFiles(storage_path('kuangshi.log'), 'info');
        Log::info('sign params:', [
            'A' => $requestURI,
            'D' => $requestBodyMD5,
            'd_json' => $reqParamJson,
            'E' => $secretKey,
            'F' => [
                'ctimestamp' => $ctimestamp,
                'cnonce' => $cnonce,
                'cappkey' => $cappkey,
            ],
            'csign' => $csign,
            'sign' => $sign,
        ]);
        return [
            'uri' => $requestURI,
            'headers' => [
                'ctimestamp' => $ctimestamp,
                'cnonce' => $cnonce,
                'cappkey' => $cappkey,
                'csign' => $sign,
                'Content_Type' => 'application/json'
            ],
            'body_json' => $reqParamJson,
            'body_array' => $reqParamArray,
            'sign' => $sign,
        ];
    }

    public static function notifyCheck($reqParamJson, $cnonce, $ctimestamp, $notify_csign)
    {        
        
        $requestURI = sprintf('/%s/notify',config('kuangshi.route.prefix'));

        $secretKey = config('kuangshi.SecretKey');
        $cappkey = config('kuangshi.AppKey');

        if (self::is_empty($cappkey)) {
            throw new Exception("参数错误，appKey不能为空或者空字符串");
        }
        if (self::is_empty($secretKey)) {
            throw new Exception("参数错误，secretKey不能为空或者空字符串");
        }

        $requestBodyMD5 = self::encrypt_md5($reqParamJson);

        $csign = sprintf('%s-%s-%s-%s-%s-%s', $requestURI,$requestBodyMD5, $secretKey, $ctimestamp, $cnonce, $cappkey);        
        $sign = md5($csign);
        return $sign == $notify_csign;

        // return [
        //     'A' => $requestURI,
        //     'D' => $requestBodyMD5,
        //     'E' => $secretKey,
        //     // 'ctimestamp'=>$ctimestamp,
        //     // 'cnonce'=>$cnonce,
        //     // 'cappkey'=>$cappkey,
        //     'csign' => $csign,
        //     'params'=>compact('requestURI','reqParamJson','requestBodyMD5','ctimestamp','cnonce','cappkey',
        //     'secretKey'),            
        //     'sign'=>$sign,
        //     'notify_csign' => $notify_csign,
        // ];
        
    }

    /**
     * 根据字符串生成md5值
     * @param src
     * @return
     */
    public static function encrypt_md5($src)
    {
        if (self::is_empty($src)) {
            return $src;
        } else {
            return md5($src);
        }
    }

    /**
     * 判断是否为空字符串
     */
    public static function is_empty($str)
    {
        return (trim($str) === '' || !isset($str));
    }
}
