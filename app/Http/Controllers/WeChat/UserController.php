<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    public function login(Request $request)
    {
        $oauth = $this->app->oauth;
        $user = $oauth->user(); // 微信给我们提供的用户信息

        $request->session()->put('user' , $user);
        return redirect('center');
    }

    // 检测session
    public function center(Request $request)
    {
        if( !$request->session()->has('user') ) {
            $oauth = $this->app->oauth;
            return $oauth->redirect();
        }
        return view('wechat/index');
    }

    public function user_center(Request $request)
    {
        if( !$request->session()->has('user') ) {
            $oauth = $this->app->oauth;
            return $oauth->redirect();
        }
        $user_info = session('user');
        $user_info = $user_info['original'];
        //判断.存数据库
        $res = DB::table('users')->where('openid', $user_info['openid'])->first();
        if (!$res) {
            $data = [
                'openid' => $user_info['openid'],
                'nickname' => $user_info['nickname'],
                'head_pic' => $user_info['headimgurl'],
                'status' => 0,
                'create_time' => time(),
                'last_login' => time()
            ];
            DB::table('users')->where('openid', $user_info['openid'])->insert($data);
        } else {
            $data = ['last_login' => time()];
            DB::table('users')->where('openid', $user_info['openid'])->update($data);
        }

        return view('wechat/user', $user_info);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
    }
}
