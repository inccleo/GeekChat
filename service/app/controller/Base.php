<?php

namespace app\controller;
use support\Response;

class Base
{
    public function json(array $data=[]): Response
    {
        return json(['code' => 0, 'msg' => 'ok','data'=>$data]);
    }

    public function error(string $msg='参数错误',int $code=400): Response
    {
        return new Response($code, ['Content-Type' => 'application/json'], json_encode([
            'code' => $code, 'msg' => $msg,'data'=>null], JSON_UNESCAPED_UNICODE));
    }
}
