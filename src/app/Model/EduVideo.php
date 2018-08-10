<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/12/6
 * Time: 09:51
 */
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class EduVideo extends NotORM{

    protected function getTableName($id){
        return 'edu_video';
    }

    public function getList(){


        return $this->get('1');

    }

}