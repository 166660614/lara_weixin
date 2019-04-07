<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeixinController extends Controller
{
    public function viewMenu(){
        return view('weixin.menu');
    }
    public function passMenu(Request $request){
        $fname=$request->input();
        print_r($fname);exit;
    }
//    public function index(){
//        $redirect_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//        $data=[
//            'redirect_url'=>urlencode($redirect_url),
//        ];
//        return view('welcome',$data);
//    }
    public function index(){
        return view('test');
    }
}
