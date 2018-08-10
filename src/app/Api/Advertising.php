<?php
namespace App\Api;

use PhalApi\Api;

/**
 * 广告板
 */
class Advertising extends BaseApi{



    public function getRules() {
        return array(
            'upload' => array(
                'file' => array(
                    'name' => 'file',
                    'type' => 'file',
                    'min' => 0,
                    'max' => 1024 * 1024,
                    'range' => array('image/jpg', 'image/jpeg', 'image/png'),
                    'ext' => array('jpg', 'jpeg', 'png')
                )
            ),
            "postInfo"=>array(
                'uid'=>array('name'=>"uid",'type' => 'int','require' => false),
                'cate_id'=>array('name'=>"cate_id",'type' => 'int','require' => true),
                'cate_name'=>array('name'=>"cate_name",'type'=>"string",'require' => true),
                'content'=>array('name'=>"content",'type' => 'string','require' => true),
                'validity'=>array('name'=>"validity",'type' => 'int','require' => true),
                'price'=>array('name'=>"price",'type' => 'int','require' => true),
            ),
            'getMyInfoList'=>array(
                'uid'=>array('name'=>"uid",'type' => 'int','require' => true),
                'page'=>array('name'=>"page",'type' => 'int','require' => true),
                'perpage'=>array('name'=>"perpage",'type' => 'int','require' => false),
            ),
        );
    }
    /**
     * 获取发布信息列表
     */
    public function getMyInfoList()
    {
        $data = $this->loadModel('advertising')->getListPage("*",array("uid"=>$this->uid),$this->page,$this->perpage);
        return $data;
    }
    /**
     * 获取单条信息
     */
    public function getMyInfo()
    {
        $data = $this->loadModel('advertising')->getInfo("*",array("uid"=>$this->uid));
        return $data;
    }
    /**
     * 获取分类
     */
    public function getCate()
    {
        $data = $this->loadModel('advertising_cate')->getListPage();
        return $data;
    }
    /**
     * 发布信息
     */
    public function postInfo()
    {
        $data = $this->loadModel('advertising')->addAD(array(
            'uid' => $this->uid,
            'cate_id' => $this->cate_id,
            'cate_name' => $this->cate_name,
            'content' => $this->content,
            'validity' => $this->validity,
            'addtime' => time(),
            'endtime' => time()+(86000*$this->validity),
            'ispay' => 0,
            'payfigure' => $this->price,
        ));
        return $data;
    }
}