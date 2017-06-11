<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use App\User;

class WxController extends Controller
{
    protected $app = null;

    public function __construct() {
        
        $options = [
            'debug'  => true,
            'app_id' => 'wxb3f8abd89667aa89',
            'secret' => 'fd63b31f7420fc824353c397c32e3594',
            'token'  => 'jkdslajfdksaf',


            // 'aes_key' => null, // 可选

            'log' => [
                'level' => 'debug',
                'file'  => 'D:/www/20160328/fenxiao/public/wechat.log', // XXX: 绝对路径！！！！
            ],
            'guzzle' => [
                'timeout' => 5.0,// 超时时间（秒）
                'verify' => false,// 关掉 SSL 认证（强烈不建议！！！）
                ],

            //...
        ];

        // 创建微信应用
        $this->app = new Application($options);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     

        // 创建微信服务器
        $server = $this->app->server;

        // 在微信服务器上监听事件/消息
        $server->setMessageHandler(function ($message) {
            if($message->MsgType == 'event' && $message->Event=='subscribe') {
                return $this->guanzhu($message);
            } else if($message->MsgType == 'event' && $message->Event=='unsubscribe') {
                return $this->quguan($message);
            }
        });

        $response = $server->serve();

        // 将响应输出
        return $response;   
    }

    public function guanzhu($message) {
        // 获取该用户的信息,如头像,openid,关注时间,写入users表
        /*
         1. 建立users表和迁移文件
         2. 执行迁移
         3. 从$message中,得到用户信息,写入users表--->userModel
         4. 获取用户信息
        */

         // 得到userService实例
        $userservice = $this->app->user;
        $fans = $userservice->get($message->FromUserName);

        /*$user = new User();
        $user->openid = $message->FromUserName;
        $user->name = $fans->nickname;
        $user->subtime = time();
        $user->save();

        // 生成二维码
        $user->qrimg = $this->qr($user->uid);
        $user->save();*/
        
        /*
        1.  如果数据库有此openid,且state=1
        直接return;

        2. 有此openid,且state=0
        {
        state =1;
        }

        3. 无此openid

        if(有场景id)
        elseif(没有场景id)
        */

        $qrid = false;
        if(isset($message->EventKey)) {
            $qrid = substr($message->EventKey, 8);
        }

        $user = User::where('openid' , $message->FromUserName)->first();
        
        if($user && $user->state == 0) {
            $user->state = 1;
            $user->save();
        } 

        if(!$user) {
            $user = new User();
            $user->openid = $message->FromUserName;
            $user->name = $fans->nickname;
            $user->subtime = time();

            if($qrid) {
                // 层级关系
                $prow = User::find($qrid);
                $user->p1 = $qrid;
                $user->p2 = $prow->p1;
                $user->p3 = $prow->p2;
            }

            $user->save();
            $user->qrimg = $this->qr($user->uid);
            $user->save();
        }


        return new Text(['content'=>"您好！欢迎关注我!"]);
    }

    public function quguan($message) {
        $fans = User::where('openid' , $message->FromUserName)->first();
        if($fans) {
            $fans->state = 0;
            $fans->save();
        }
    }

    public function qr($uid) {
        $qrcode = $this->app->qrcode;
        $result = $qrcode->forever($uid);// 或者 $qrcode->forever("foo");
        $ticket = $result->ticket;
        $url = $qrcode->url($ticket);

        $img = file_get_contents($url);
        $qr = $this->mkd() . '/qr_'.$uid.'.jpg';
        file_put_contents(public_path() . $qr , $img);

        return $qr;
    }

    // 根据年月日生成目录
    protected function mkd() {
        $today = date('/Y/m');

        if( !file_exists( public_path() . $today ) ) {
            mkdir( public_path() . $today , 0777 , true);
        }

        return $today;
    }

}
