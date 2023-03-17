<?php

namespace app\controller;

use app\service\PassportService;
use LinFly\Annotation\Annotation\Inject;
use LinFly\Annotation\Route\Controller;
use LinFly\Annotation\Route\Route;
use support\Request;
use support\Response;

#[Controller(prefix: '/passport')]
class PassportController extends Base
{
    #[Inject]
    protected PassportService $service;

    /**
     * 登录
     * @param Request $request
     * @return Response
     */
    #[Route(path: 'login', methods: 'post')]
    public function login(Request $request): Response
    {
        $code = $request->input('code');
        if (empty($code)) {
            return $this->error('code必填');
        }
        $session = $this->service->session($code);
        if (isset($session['errcode'])) {
            return $this->error($session['errmsg']);
        }
        //是否注册
        $openid = $session['openid'];
        if (!$this->service->isRegister($openid)) {
            $this->service->register($session['openid']);
        }

        return $this->json([
            'token' => $openid
        ]);
    }
}