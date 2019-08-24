<?php
/**
 *
 * 瞩目 调用相关
 *
 * Created by PhpStorm.
 * User: 张秀雨
 * Date: 2019/7/31
 * Time: 8:50
 *
 */
require_once 'SendRequestZhuMu.php';
require_once 'Api/UserZhuMu.php';
require_once 'Api/MeetingZhuMu.php';

class ApiBase {


    public function __construct($api_key, $api_secret)
    {
        $this->SendRequest = new SendRequestZhuMu($api_key,$api_secret);
    }

    public function user()
    {
        return new UserZhuMu($this->SendRequest);
    }


    public function meeting()
    {
        return new MeetingZhuMu($this->SendRequest);
    }

}