<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/12/31
 * Time: 15:02
 */
class ToKenFilter implements \PhalApi\Filter {

    public function check()
    {
        $signature = \PhalApi\DI()->request->get('signature');
        $timestamp = \PhalApi\DI()->request->get('timestamp');
        $nonce = \PhalApi\DI()->request->get('nonce');

        $token = 'Your Token Here ...';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if ($tmpStr != $signature) {
            throw new BadRequestException('wrong sign', 1);
        }
    }
}