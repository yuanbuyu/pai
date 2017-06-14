<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;

class UserController extends Controller
{
    protected $app = null;

    public function __construct() {
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
            'oauth' => [
                  'scopes'   => ['snsapi_userinfo'],
                  'callback' => '/login',
              ],

            //...
        ];

        // 创建微信应用
        $this->app = new Application($options);
    }

    //
    public function login() {
        $oauth = $this->app->oauth;
        $user = $oauth->user(); // 微信给我们提供的用户信息

        session()->put('user' , $user);
        return redirect('center');
    }

    // 检测session
    public function center(Request $request) {
        if( !$request->session()->has('user') ) {
            $oauth = $this->app->oauth;
            return $oauth->redirect();
        }

        return 'hello ,user';
    }

    public function logout() {
        session()->forget('user');
    }
}
