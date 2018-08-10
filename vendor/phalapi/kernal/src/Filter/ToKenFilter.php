<?php
namespace PhalApi\Filter;

use PhalApi\Exception;
use PhalApi\Filter;

/**
 * NoneFilter 无作为的拦截器
 *
 * @package     PhalApi\Filter
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author      dogstar <chanzonghuang@gmail.com> 2015-10-23
 */

class ToKenFilter implements Filter {
    protected $token;

    public function __construct($token = 'token') {
        $this->token = $token;

    }

    public function check() {
        $token = \PhalApi\DI()->request->get('token');
        if (!$token){
            $token = \PhalApi\DI()->request->getHeader('token');
            if (!$token){
                throw new Exception('token不能为空', 205);
            }
        }
        $sign = \PhalApi\DI()->cache->get($token);
        if ($token!=$sign){
            throw new Exception('token效验失败', 205);
        }
    }
}
