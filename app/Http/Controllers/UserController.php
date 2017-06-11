<?php

namespace App\Http\Controllers;

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
    public function center(Request $req) {
        if( !$req->session()->has('user') ) {
            $oauth = $this->app->oauth;
            return $oauth->redirect();
        }

        return 'hello ,user';
    }

    public function logout() {
        session()->forget('user');
    }
}
