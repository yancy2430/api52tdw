<?php
namespace App\Api;

use PhalApi\Api;

/**
 * 新闻模块
 */
class News extends BaseApi
{

    public function getRules()
    {
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
            "getNewsList" => array(

            )
        );
    }

    /**
     * 获取新闻列表
     */
    public function getNewsList()
    {
        $m = $this->loadModel('news_list');
        $data = $m->getListNews();
        return $data;
    }

    public function getNewsContent(){
        $m = $this->loadModel('news_list');
        $data = $m->getInfo("id,title,source,addtime,image,content",array('id'=>I('id')));
        $data['data']['content'] = htmlspecialchars_decode($data['data']['content']);
        return $data;
    }
    public function test(){
        return 11;
    }
}