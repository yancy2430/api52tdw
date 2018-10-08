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
            'uploadImages' => array(
                'file' => array(
                    'name' => 'file',
                    'type' => 'file',
                    'min' => 0,
//                    'max' => 1024 * 1024,
                    'range' => array('image/jpg', 'image/jpeg', 'image/png'),
                    'ext' => array('jpg', 'jpeg', 'png')
                ),
                'aid'=>array('name'=>"aid",'type' => 'int','require'=>true,'desc'=>'问题ID'),

            ),
            "addAnswer"=>array(
                'uid'=>array('name'=>"uid",'type' => 'int','require'=>true,'desc'=>'提问用户ID'),
                'username'=>array('name'=>"username",'type' => 'string','require'=>true,'desc'=>'提问用户名'),
                'message'=>array('name'=>"content",'require'=>true,'desc'=>'问题的详细描述'),
                'images'=>array('name'=>"images",'type' => 'array','require'=>false,'desc'=>'问题图片，多图或单图，file数组'),
                'reward'=>array('name'=>"reward",'type' => 'int','default'=>0,'require'=>true,'desc'=>'悬赏金额 ，2、5、10、20'),
                'ismeg'=>array('name'=>"ismeg",'type' => 'int','default'=>0,'require'=>true,'desc'=>'是否短信通知，1通知 0不通知'),
                'anonymous'=>array('name'=>"anonymous",'type' => 'int','default'=>0,'require'=>true,'desc'=>'是否匿名发布，1匿名 0不匿名')
            ),
            "addAnswerPost"=>array(
            'answerid'=>array('name'=>"answerid",'type' => 'int','require'=>true,'desc'=>'所回答的问题ID'),
            'uid'=>array('name'=>"uid",'type' => 'int','require'=>true,'desc'=>'回答者ID'),
            'username'=>array('name'=>"username",'type' => 'string','require'=>true,'desc'=>'回答者用户名'),
            'message'=>array('name'=>"message",'require'=>true,'desc'=>'回答内容'),
            'images'=>array('name'=>"images",'type' => 'array','require'=>false,'desc'=>'问题图片，多图或单图，file数组'),
            'anonymous'=>array('name'=>"anonymous",'type' => 'int','default'=>0,'require'=>true,'desc'=>'是否匿名发布，1匿名 0不匿名')
        )
        );
    }
    /**
     * 获取问答列表
     */
    public function getList()
    {
        $data = $this->loadModel('answer')->getListPage();
        for ($i=0;$i<count($data['items']);$i++){
            $data['items'][$i]['images'] = $this->loadModel('answerImg')->getListPage();
        }
        return $data;
    }

    /**
     * 发布问题
     * @return string title 标题
     */
    public function addAnswer()
    {
//        $images = array();
//        if ($this->images!=null && $this->images!="")
//        $images = $this->multipleUpload($this->images,true);
        $data = $this->loadModel('answer')->addAnswer(array(
            'uid'=>$this->uid,
            'username'=>$this->username,
            'message'=>$this->message,
//            'images'=>$images,
            'reward'=>$this->reward,
            'ismeg'=>$this->ismeg,
            'anonymous'=>$this->anonymous,
        ));
        return $data;
    }

    public function uploadImages()
    {
        $images = $this->singleUpload($this->file);
        if ($i = intval($this->aid)){
                $this->loadModel('answer_img')->add(array(
                    'image'=>$images['file'],
                    'aid'=>$i
                ));
        }
        return $images;
    }

    /**
     * 发布回答
     * @return string title 标题
     */
    public function addAnswerPost()
    {
        if ($this->images!=null && $this->images!="")
            $images = $this->multipleUpload($this->images,true);
            $data = $this->loadModel('answer')->addAnswer(array(
            'uid'=>$this->uid,
            'username'=>$this->username,
            'title'=>$this->title,
            'message'=>$this->message,
            'images'=>$images,
            'image'=>$images[0],
            'reward'=>$this->reward,
            'ismeg'=>$this->ismeg,
            'anonymous'=>$this->anonymous,
        ));
        return $data;
    }


}