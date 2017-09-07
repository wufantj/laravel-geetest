<?php

namespace WuFan\Geetest\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Agent;

class GeetestController
{
    /**
     * @var \GeetestLib
     */
    protected $geetestLib;

    /**
     * 构造函数
     */
    public function __construct()
    {
        require_once __DIR__ . '/../../../sdk/class.geetestlib.php';

        $this->geetestLib = new \GeetestLib(config('geetest.captcha_id'), config('geetest.private_key'));
    }

    /**
     * 获取验证码
     *
     * @param Request $request
     * @return string
     */
    public function get(Request $request)
    {
        $status = $this->geetestLib->pre_process([
            'user_id' => Auth::id(),
            'client_type' => Agent::isDesktop() ? 'web' : 'h5',
            'ip_address' => $request->ip(),
        ], 1);

        $request->session()->put('gtserver', $status);
        $request->session()->put('user_id', Auth::id());


        return $this->geetestLib->get_response_str();
    }
}
