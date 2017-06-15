<?php

namespace App\Http\Controllers\WeChat;

use EasyWeChat\Support\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Illuminate\Support\Facades\DB;

class WxController extends Controller
{
    protected $app = null;

    public function __construct()
    {
        
        $options = [
            'debug'  => true,
            'app_id' => 'wx1921e49262996ed3',
            'secret' => 'd3e192c0b49f6a3fde1e61c2e795638d',
            'token'  => 'yuanbuyu',
            'log' => [
                'level' => 'debug',
                'file'  => 'D:/xampp/htdocs/pai/public/wechat.log', // XXX: 绝对路径！！！！
            ],
            'guzzle' => [
                'timeout' => 5.0,// 超时时间（秒）
                'verify' => false,// 关掉 SSL 认证（强烈不建议！！！）
                ],
        ];

        // 创建微信应用
        $this->app = new Application($options);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {

        // 创建微信服务器
        $server = $this->app->server;

        // 在微信服务器上监听事件/消息
        $server->setMessageHandler(function ($message){
            if($message->MsgType == 'event' && $message->Event=='subscribe') {
                return $this->follow($message);
            } else if($message->MsgType == 'event' && $message->Event=='unsubscribe') {
                return $this->un_follow($message);
            }
        });

        $response = $server->serve();

        // 将响应输出
        return $response;   
    }

    public function follow($message)
    {
        $user_service = $this->app->user;
        $fans = $user_service->get($message->FromUserName);
        $data = [
            'openid'   => $message->FromUserName,
            'nickname' => $fans->nickname,
            'head_pic' => $fans->headimgurl,
            'status' => 1,
        ];
        $user_info = DB::table('users')->where('openid', $data['openid'])->first();
        //已经存在用户信息了,修改用户更新时间
        if ($user_info) {
            $data['update_time'] = time();
            $res = DB::table('users')->where('openid', $data['openid'])->update($data);
        }
        //新关注的用户
        else {
            $data['create_time'] = time();
            $res = DB::table('users')->where('openid', $data['openid'])->insert($data);
        }
        if (!$res) {
            return new Text(['content'=>"您好！$fans->nickname,  信息读取失败!请重新关注!!"]);
        }
        return new Text(['content'=>"您好！$fans->nickname,  欢迎关注尚鼎商城!"]);
    }

    public function un_follow($message)
    {
       $openid = $message->FromUserName;
       $res = DB::table('users')->where('openid', $openid)->update(['status'=>0]);
       if (!$res) {
           Log::error($openid . "un_follow Error" . date('Y-m-d H:i:s'));
       }
    }
}
