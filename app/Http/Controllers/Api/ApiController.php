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
        $enc_data=base64_encode(openssl_encrypt($data,$method,$key,$option,$iv));
        $pri_secret=openssl_pkey_get_private(file_get_contents('./priv.key'));
        openssl_sign($enc_data,$signature,$pri_secret,OPENSSL_ALGO_SHA256);
        openssl_free_key($pri_secret);//释放资源
        $sign=base64_encode($signature);
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
        $post_data=['post_data'=>$enc_data,'sign'=>$sign];
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $res_data =curl_exec($curl);
        print_r($res_data);exit;
        $res_method='AES-128-CBC';
        $res_salt='salt99';
        $res_key="reskey";
        $res_option=OPENSSL_RAW_DATA;
        $res_iv=substr(md5($res_data['res_time'].$res_salt),5,16);
        $dec_data=openssl_decrypt($res_data,$res_method,$res_key,$res_option,$res_iv);
        print_r($dec_data);
        //关闭URL请求
        curl_close($curl);
    }
}
