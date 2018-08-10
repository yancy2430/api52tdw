<?php
/**
 * 统一访问入口
 */

error_reporting(E_ALL^E_NOTICE);
require_once dirname(__FILE__) . '/init.php';

/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * <code>
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * </code>
 * @param string $name 变量的名称 支持指定类型
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * @return mixed
 */
function I($name, $default = '', $filter = null)
{
    if (array_key_exists($name, $_REQUEST)) {
        if ($_REQUEST[$name] != '') {
            return $_REQUEST[$name];
        } else if ($default) {
            return $default;
        } else {
            return '';
        }
    }
}

$pai = new \PhalApi\PhalApi();
$pai->response()->output();

