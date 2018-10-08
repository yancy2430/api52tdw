<?php
namespace App\Model;


/**
 *
CREATE TABLE IF NOT EXISTS `tdw_user` (
`uid` int(11) NOT NULL COMMENT '用户ID',
`username` varchar(40) NOT NULL COMMENT '用户名称',
`phone` varchar(12) NOT NULL COMMENT '手机号',
`password` int(50) NOT NULL COMMENT '密码',
`email` varchar(20) NOT NULL COMMENT '邮箱',
`random` varchar(10) NOT NULL COMMENT '随机码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

 */
class User extends BaseModel  {


    /**
     * 获取用户信息
     * @param $username 用户名
     */
    public function getUserInfoByName($username){
        $user = $this->getORM($this->table);
        $userData = $user->select("*")->or("username",$username)->or("mobile",$username)->fetchOne();
        return $userData;
    }
    /**
     * 更新user_token
     */
    public function setToken($id){
        $token = md5($id.'dklawhfaiwdoawkaoifiw'.time());
        \PhalApi\DI()->cache->set($token, $token, 604800);
        $user = $this->getORM($this->table);
        if ($user->where(array('id'=>$id))->update(array('token'=>$token))){
            return $token;
        }
    }
    public function getToken($token){
        $sign = \PhalApi\DI()->cache->get($token);
        if ($token!=$sign){
            throw new Exception('token效验失败', 205);
        }else{
            $user = $this->getORM($this->table);
            return $user->where(array('token'=>$token))->fetchOne();
        }
    }
    /**
     * 获取用户信息
     * @param $username 微信开放平台ID
     */
    public function getUserByUnionID($unionid){
        $user = $this->getORM($this->table);
        $userData = $user->select("*")->or("unionid",$unionid)->fetchOne();
        return $userData;
    }
    public function regWxapp($unionid,$username,$avater){
        $user = $this->getORM($this->table);
        $id = $user->insert(array('mobile'=>"0000_".time(),'unionid'=>$unionid,'username'=>$username,'avater'=>$avater));
        return $id['id'];
    }
    public function reg($mobile,$username,$password){
        $user = $this->getORM($this->table);
        $id = $user->insert(array('mobile'=>$mobile,'username'=>$username,'password'=>$password));
        return $id['id'];
    }

}