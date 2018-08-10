<?php
namespace App\Api;
use PhalApi\Exception;


/**
 * 用户操作
 * Class User
 * @package App\Api
 */
class User extends BaseApi {

    public function getRules() {
        return array(
            'login' => array(
                'username' 	=> array('name' => 'username','require' => true),
                'password' => array('name' => 'password','require' => true)
            ),
            'register' => array(
                'mobile' 	=> array('name' => 'mobile','require' => true),
                'username' 	=> array('name' => 'username','require' => true),
                'password' => array('name' => 'password','require' => true),
                'vcode' 	=> array('name' => 'vcode','require' => true)
            ),
            'getVcode'=> array(
                'mobile' 	=> array('name' => 'mobile','require' => true)
            ),
            'getUserInfo'=> array(
                'token' 	=> array('name' => 'token','require' => true)
            ),
            'getUnionId'=> array(
                'code' 	=> array('name' => 'code','require' => true),
                'username' 	=> array('name' => 'username','require' => true)
            ),
        );
    }

    /**
     * 用户登录
     * @desc 传入username,password
     * @return mixed
     */
    public function login(){
        return $this->loadModel('user')->loginByPassword($this->username,$this->password);
    }
    /**
     * 获取用户信息
     */
    public function getUserInfo(){
        return $this->loadModel("user")->getUserInfoByToKen($this->token);
    }
    /**
     * 用户注册
     * @return mixed
     */
    public function register(){

        $vcode = $this->DI->cache->get($this->mobile);

        if (!$vcode){
            throw new Exception("验证码已过期",205);
        }
        if ($vcode!= md5(base64_encode(md5($this->vcode)))){
            throw new Exception("验证码错误",205);
        }
        return $this->loadModel('user')->RegisterByMobile($this->mobile,$this->username,$this->password);
    }

    /**
     * 获取验证码
     */
    public function getVcode(){
        $code = \App\generate_code(6);
        $vcode = md5(base64_encode(md5($code)));
        $this->DI->cache->set($this->mobile, $vcode, 600);
        $this->DI->sms->sendMessage($this->mobile, $code);
    }


    /**************小程序登录*****************/
    public function getUnionId(){
        $unionid = $this->DI->wx->getUnionID($this->code);
        if (isset($unionid['unionid'])){
            $us = $this->loadModel("user");
            if ($u = $us->getUserInfoByUnionID($unionid['unionid'])){
                return $u;
            }else{
                return $us->RegisterByWxApp($unionid['unionid'],$this->username);
            }
        }


    }

}