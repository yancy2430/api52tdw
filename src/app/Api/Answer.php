<?php
namespace App\Api;

use PhalApi\Api;

/**
 * 问答社区
 */
class Answer extends BaseApi
{

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
            "addAnswer"=>array(
                'title'=>array('name'=>"title",'type' => 'string'),
                'message'=>array('name'=>"message"),
                'images'=>array('name'=>"images",'type' => 'array'),
                'reward'=>array('name'=>"reward",'type' => 'int'),
                'ismeg'=>array('name'=>"ismeg",'type' => 'int')
            )
        );
    }
    /**
     * 获取问答列表
     */
    public function getList()
    {
        $data = $this->loadModel('answer')->getListPage();
        return $data;
    }

    /**
     * 发布问题
     */
    public function addAnswer()
    {
        $images = $this->multipleUpload($this->images,true);
        $data = $this->loadModel('answer')->addAnswer(array(
            'title'=>$this->title,
            'message'=>$this->message,
            'images'=>$images,
            'image'=>$images[0],
            'reward'=>$this->reward,
            'ismeg'=>$this->ismeg,
        ));
        return $data;
    }


}