<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2018/1/8
 * Time: 13:46
 */
class Sms {
    protected $config = array(
        //平台账号
        'username' => 'zhe2430',
        //密码
        'password' => 'yangzhe2430',
        //发送网关
        'gateway' => 'http://api.chanyoo.cn/utf8/interface/send_sms.aspx'
    );


    public function sendMessage($mobile,$vcode){
        $msg = "尊敬的用户你好：感谢您注册掌上通道，本次验证码为：".$vcode."，有效时间30分钟，请及时完成验证，如不是本人操作请忽略。【通道网】";
        throw new Exception("发送成功".$vcode, 200);
        try {
            // 实例化时也可指定失败重试次数，这里是2次，即最多会进行3次请求
            $curl = new \PhalApi\CUrl(2);
            // 第二个参数为待POST的数据；第三个参数表示超时时间，单位为毫秒
            $rs = $curl->post($this->config['gateway'], array(
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'content' => $msg,
                'receiver' => $mobile,
            ), 3000);
            // 一样的输出
            $simple = $rs;
            $p = xml_parser_create();
            xml_parse_into_struct($p, $simple, $vals, $index);
            xml_parser_free($p);
            throw new Exception($vals[3]['value'].$vcode, 200);
        } catch (\PhalApi\Exception\InternalServerErrorException $ex) {

            throw new Exception('短信发送错误，请联系管理员', 400);
        }
    }
}