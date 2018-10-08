<?php
namespace App\Domain;


use PhalApi\Exception;

class User extends \App\Model\User {

    private $tokenkey = "dklawhfaiwdoawkaoifiw";
    /**
     * 密码登录
     */
    public function loginByPassword($name,$password){
        $user = $this->getUserInfoByName($name);
        if (!$user){
            throw new Exception('账号不存在', 202);
        }else if ($user['password']==$password){
            $user['token']=$this->setToken($user['id']);
            return $user;
        }else{
            throw new Exception('密码错误', 201);
        }
    }
    /**
     * 获取用户信息
     */
    public function getUserInfoByToKen($Token)
    {
        if ($Token){
            return $this->getToken($Token);
        }else{
            throw new Exception('Token不能为空', 204);
        }
    }
    /**
     * 获取用户信息
     */
    public function getUserInfoByUnionID($unionid)
    {
        if ($unionid){
            return $this->getUserByUnionID($unionid);
        }else{
            throw new Exception('unionid不能为空', 204);
        }
    }
    /**
     * 手机注册
     */
    public function RegisterByMobile($mobile,$username,$password){
        if ($this->getUserInfoByName($mobile)){
            throw new Exception('手机号已被注册', 203);

        }
        if ($this->getUserInfoByName($username)){
            throw new Exception('用户名已被注册',204);
        }
        if ($uid = $this->reg($mobile,$username,$password)){
            $user = $this->getUserInfoByName($mobile);
            return $user;
        }else{
            throw new Exception('注册失败，请联系管理员',500);
        }

    }

    /**
     * 小程序注册注册
     */
    public function RegisterByWxApp($unionid,$username,$avater){



        if ($this->getUserInfoByName($username)){
            $username = "wx_".$username;
        }
        if ($uid = $this->regWxapp($unionid,$username,$avater)){
            $this->setToken($uid);

            $user = $this->getUserByUnionID($unionid);
            return $user;
        }else{
            throw new Exception('注册失败，请联系管理员',500);
        }
    }
}
$model = new User();