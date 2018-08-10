<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/12/6
 * Time: 09:51
 */
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Advertising extends NotORM{

    protected function getTableName($id){
        return 'advertising';
    }

    public function getList(){


        return $this->get('1');

    }

}