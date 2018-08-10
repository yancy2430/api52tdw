<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/12/6
 * Time: 09:51
 */
namespace App\Model;


class News extends BaseModel {

    protected function getTableName($id){
        return 'edu_video';
    }

    public function getListNews($page = '',$perpage =''){
        $page = $page?$page:I('p')?I('p'):1;
        $perpage = $perpage?$perpage:I('psize')?intval(I('psize')):15;
        return $this->getORM()->queryAll("select a.id,a.title,a.source,a.addtime,b.images from pre_news_list a left join (select aid,CONCAT('',GROUP_CONCAT(image separator ','), '') as images from pre_news_images GROUP BY aid) b on a.id = b.aid where 1 LIMIT ".($page-1)*$perpage.",".$perpage." ",array());

    }

}