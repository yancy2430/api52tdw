<?php
namespace App\Api;
use PhalApi\Api;
//use App\Domain\Tools\LoansCredit;
class BaseApi extends Api {

    protected $DI = null;


    public function __construct(){
        $this->DI = \PhalApi\DI();
    }


    public function loadModel($name) {

        $arr = explode('.',$_REQUEST['s']);
        $s = explode('_',$arr[0]);
        $mod = '';
        $cls = "";
        for ($i=0;$i<count($s);$i++){
            $mod .= "/".$s[$i];
        }
        $cls = $s[(count($s)-1)];
        require (__DIR__.'/../Domain'.$mod.'.php');
        $model->loadModel(strtolower($name));
        return $model;
    }

    /**
     * 上传文件
     * @return string $url 绝对路径
     * @return string $file 相对路径，用于保存至数据库，按项目情况自己决定吧
     */
    public function singleUpload($file,$baser64=false) {

        //设置上传路径 设置方法参考3.2
        \PhalApi\DI()->ucloud->set('save_path',date('Y/m/d'));

        //新增修改文件名设置上传的文件名称
//        \PhalApi\DI()->ucloud->set('file_name', 'avatar');

        //上传表单名
        $rs = \PhalApi\DI()->ucloud->upfile($file,$baser64);

        return $rs;
    }
    /**
     * 上传文件
     * @return string $url 绝对路径
     * @return string $file 相对路径，用于保存至数据库，按项目情况自己决定吧
     */
    public function multipleUpload($files,$baser64=false) {
        //设置上传路径 设置方法参考3.2
        \PhalApi\DI()->ucloud->set('save_path', date('Y/m/d'));
        $data = array();
        //上传表单名
        foreach ($files as $file) {
            //新增修改文件名设置上传的文件名称
            $data[] = \PhalApi\DI()->ucloud->upfile($file,$baser64);
        }
        return $data;
    }

    public function verifyToKen($token){
        $a = \PhalApi\DI()->cache->get($token);
        if ($token==$a){
            return true;
        }else{
            return false;
        }

    }

}