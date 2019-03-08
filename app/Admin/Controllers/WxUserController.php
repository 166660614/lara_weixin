<?php

namespace App\Admin\Controllers;

use App\Model\WxUserModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use GuzzleHttp;
class WxUserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content 客服聊天
     * @return Content
     */
    public function create(Content $content)
    {
        $user_id=$_GET['user_id'];
        $data=WxUserModel::where(['id'=>$user_id])->first();
        print_r($data);exit;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxUserModel);
        $grid->id('用户ID');
        $grid->nickname('用户昵称');
        $grid->headimgurl('头像')->display(function ($img){
        return "<img src=".$img.">";
         });
        $grid->subscribe_time('关注时间')->display(function ($time){
            return date('Y-m-d H:i:s',$time);
        });
        $grid->sex('性别')->display(function ($sex){
            if($sex==1){
                return '男';
            }elseif($sex==2){
                return '女';
            }else{
                return '未知';
            }
        });
        $grid->actions(function ($actions) {
            // 获取当前行主键值
            $id=$actions->getKey();
            $actions->prepend('<a href="/admin/weixin/usersinfo/chat?user_id='.$id.'"><i class="fa fa-paper-plane"></i></a>');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WxUserModel::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxUserModel);



        return $form;
    }
    //删除
    public function destroy($id)
    {
        $where=[
            'id'=>$id,
        ];
        $res=Info::where($where)->delete();
        if($res){
            $response = [
                'status' => true,
                'message'   => '删除成功'
            ];
            return $response;
        }else{
            $response = [
                'status' => true,
                'message'   => '删除失败'
            ];
            return $response;
        }
    }
    //获得access_token
    public function getAccessToken(){
        return WxUserModel::getAccessToken();
    }
    //获得用户信息
    public function getUserInfo(){
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".WxUserModel::getAccessToken()."&openid=oXz456H7QsRehanDIUDEk5N-BVlo&lang=zh_CN";
        $usersInfo=json_decode(file_get_contents($url),true);
        print_r($usersInfo);
        //return $usersInfo;
    }
    //群发管理
    public function sendAllView(Content $content){
        return $content
            ->header('群发粉丝')
            ->description('点击发送，你的粉丝会受到你发送的内容')
            ->body(view('admin.sendall'));
    }
    public function sendAllAction(Request $request){
        $content=$request->input('content');
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.WxUserModel::getAccessToken();
        //请求微信接口
        $client = new GuzzleHttp\Client(['base_uri' => $url]);
        $data=[
            'filter'=>[
                'is_to_all'=>true,
            ],
            'text'=>[
                'content'=>$content
            ],
            'msgtype'=>'text'
        ];
        $r=$client->request('post',$url,['body'=>json_encode($data,JSON_UNESCAPED_UNICODE)]);
        //解析接口返回信息
        $response_arr=json_decode($r->getBody(),true);
        if($response_arr['errcode']==0){
            $res=[
                'code'=>0,
                'msg'=>'群发成功'
            ];
        }else{
            $res=[
                'code'=>1,
                'msg'=>$response_arr['errmsg']
            ];
        }
        echo json_encode($res);
    }
}
