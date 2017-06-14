<?php

namespace App\Http\Controllers\WeChat;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class MenuController extends Controller
{
    protected $app = null;
    protected $menu = null;

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
        ];

        // 创建微信应用
        $this->app = new Application($options);
        $this->menu = $this->app->menu;
    }

    public function read_menu()
    {
        return $this->menu->all();
    }

    public function add_menu()
    {
        $buttons = [
            [
                "type" => "view",
                "name" => "拍卖",
                "url"  => "http://yuanbuyu.tunnel.qydev.com/center"
            ],
        ];
        $this->menu->add($buttons);
    }
}
