<?php

namespace WuFan\Geetest\App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Agent;

class GeetestValidator
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \GeetestLib
     */
    protected $geetestLib;

    /**
     * 构造函数
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        require_once __DIR__ . '/../../sdk/class.geetestlib.php';

        $this->geetestLib = new \GeetestLib(config('geetest.captcha_id'), config('geetest.private_key'));
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        if ($this->request->session()->get('gtserver') == 1) {
            if ($this->geetestLib->success_validate(
                    $this->request->input('geetest_challenge'),
                    $this->request->input('geetest_validate'),
                    $this->request->input('geetest_seccode'),
                    [
                        'user_id' => Auth::id(),
                        'client_type' => Agent::isDesktop() ? 'web' : 'h5',
                        'ip_address' => $this->request->ip(),
                    ])
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->geetestLib->fail_validate(
                $this->request->input('geetest_challenge'),
                $this->request->input('geetest_validate'),
                $this->request->input('geetest_seccode'))
            ) {
                return true;
            } else {
                return false;
            }
        }
    }
}
