<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    public $weixin_access_token="str:weixin_access_token";
    public function valid(){
        $postdata = file_get_contents("php://input");
        $xml = simplexml_load_string($postdata);
        $log_str = date('Y-m-d H:i:s') . "\n" . $postdata . "\n<<<<<<<";
        file_put_contents('logs/wx_event.log', $log_str, FILE_APPEND);
    }
    public function getAccessToken(){
        $access_token=Redis::get(self::$weixin_access_token);
        if(!$access_token){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WEIXIN_APPID')."&secret=".env('WEIXIN_APPSECRET');
            $token_data=json_decode(file_get_contents($url),true);
            $access_token=$token_data['access_token'];
            Redis::set($this->weixin_access_token,$access_token);
            Redis::setTimeout($this->weixin_access_token,3600);
        }
        return $access_token;
    }
}