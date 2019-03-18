<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller
{
    public function test(){
        $url="http://lumen.api.com/user/api?t=".time();
        $data="kehuduan";
        $method='AES-128-CBC';
        $key="key";
        $option=OPENSSL_RAW_DATA;
        $time=time();
        $salt='salt88';
        $iv=substr(md5($time.$salt),5,16);
        $enc_data=openssl_encrypt($data,$method,$key,$option,$iv);
        $enc_data=base64_encode($enc_data);
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //关闭HEADER头
        curl_setopt($curl,CURLOPT_HEADER,0);
        //设置post数据
        $post_data=['post_data'=>$enc_data];
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        print_r($data);
    }
}
