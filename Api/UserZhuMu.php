<?php
/**
 * Created by PhpStorm.
 * User: 张秀雨
 * Date: 2019/7/31
 * Time: 9:27
 */

class UserZhuMu{


    private $SendRequest;

    public function __construct($SendRequest) {
        $this->SendRequest = $SendRequest;
    }

    public function create($user_id,$username)
    {
        $email = $user_id . $this->SendRequest->email;
        return $this->SendRequest->requestUrl([
            'email'=>"{$email}",
            'username' => "{$username}"
        ],'/v3/user/create');
    }


    public function updatePassword($zCode,$password)
    {
        return $this->SendRequest->requestUrl([
            'zcode'=>"{$zCode}",
            'password' => "{$password}"
            ],
            '/v3/user/updatepassword');
    }

    public function getUser($user_id)
    {
        $email = $user_id . $this->SendRequest->email;
        return $this->SendRequest->requestUrl([
            'logintype'=>"3",
            'loginname' => "{$email}"
        ],
            '/v3/user/get');
    }

    public function update($zcode,$username)
    {
        return $this->SendRequest->requestUrl([
            'zcode'=>"{$zcode}",
            'username' => "{$username}"
        ],
            '/v3/user/update');
    }





}