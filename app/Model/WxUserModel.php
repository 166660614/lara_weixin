<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class WxUserModel extends Model
{
    protected $table='p_wx_users';
    public $timestamps=false;
    public static $weixin_access_token="str:weixin_access_token";
    public static function getAccessToken(){
        $access_token=Redis::get(self::$weixin_access_token);
        if(!$access_token){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WEIXIN_APPID')."&secret=".env('WEIXIN_APPSECRET');
            $token_data=json_decode(file_get_contents($url),true);
            $access_token=$token_data['access_token'];
            Redis::set(self::$weixin_access_token,$access_token);
            Redis::setTimeout(self::$weixin_access_token,3600);
        }
        return $access_token;
    }
}
