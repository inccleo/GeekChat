<?php

namespace app\service;

use EasyWeChat\Factory;
use EasyWeChat\MiniProgram\Application;
use support\Db;
use support\Redis;

class PassportService
{
    public function session(string $code): array
    {
        return $this->miniApp()->auth->session($code);
    }

    public function miniApp(): Application
    {
        $config = [
            'app_id' => getenv('WX_APPID'),
            'secret' => getenv('WX_SECRET'),
        ];
        return Factory::miniProgram($config);
    }

    public function isRegister(string $openid): bool
    {
        return Db::table('users')->where('openid', $openid)->exists();
    }

    public function register(string $openid): void
    {
        $user_id = Db::table('users')->insertGetId([
            'openid' => $openid,
            'create_at' => date('Y-m-d H:i:s'),
        ]);
        //保存openid
        Redis::hSet('openids', $openid, $user_id);
    }
}