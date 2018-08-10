<?php
/**
 * 请在下面放置任何您需要的应用配置
 *
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author dogstar <chanzonghuang@gmail.com> 2017-07-13
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        //'sign' => array('name' => 'sign', 'require' => true),
    ),

    /**
     * 接口服务白名单，格式：接口服务类名.接口服务方法名
     *
     * 示例：
     * - *.*         通配，全部接口服务，慎用！
     * - Site.*      Api_Default接口类的全部方法
     * - *.Index     全部接口类的Index方法
     * - Site.Index  指定某个接口服务，即Api_Default::Index()
     */
    'service_whitelist' => array(
        'News.*',
        'user.getVcode',
        'user.login',
        'user.getUnionId',
        'user.register'
    ),
    'Image' => array(
        //要使用的类库 1:标识GD库类型 2:标识imagick库类型
        'type' => 1,
        //图像路径
        'imgname' => null
    ),

    //请将以下配置拷贝到 ./Config/app.php 文件中

    /**
     * 云上传引擎,支持local,oss,upyun
     */
    'UCloudEngine' => 'local',

    /**
     * 本地存储相关配置（UCloudEngine为local时的配置）
     */
    'UCloud' => array(
        //对应的文件路径
        'host' => '/public/upload'
    ),


    /**
     * 云上传对应引擎相关配置
     * 如果UCloudEngine不为local,则需要按以下配置
     */
    /**'UCloud' => array(
    //上传的API地址,不带http://,以下api为阿里云OSS杭州节点
    'api' => 'oss-cn-hangzhou.aliyuncs.com',

    //统一的key
    'accessKey' => '',
    'secretKey' => '',

    //自定义配置的空间
    'bucket' => '',
    'host' => 'http://image.xxx.com', //必带http:// 末尾不带/

    'timeout' => 90
    ),*/
);
