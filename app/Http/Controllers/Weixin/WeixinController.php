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
}
