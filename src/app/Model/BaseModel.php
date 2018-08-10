<?php
/**
 * Created by PhpStorm.
 * User: yangzhe
 * Date: 2017/12/6
 * Time: 10:07
 */
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class BaseModel extends NotORM
{
    protected $table = "";

    public function loadModel($table)
    {
        $this->table = $table;
        return $this;
    }
    public function Model()
    {

        return $this->getORM($this->table);
    }
    protected function getTableName($id)
    {
        return $id;
    }

    public function getListItems($state, $where = array(),$page, $perpage)
    {
        return $this->getORM($this->table)
            ->select($state)
            ->where($where)
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getListTotal($where)
    {
        $total = $this->getORM($this->table)
            ->where($where)
            ->count('id');

        return intval($total);
    }

    public function add($data)
    {
        $arr = array();
        foreach ($data as $key => $item) {
            if (!empty($item) && !is_array($item)) {
                    $arr[$key] = $item;
            }
        }
        //插入（须是同一个对象才能正确获取插入的ID）
        $rid = $this->getORM($this->table)
            ->insert($arr);
        return $rid;
    }
    public function getListPage($field="*",$where = array() , $page='', $perpage='') {
        $page = $page?$page:1;
        $perpage = $perpage?$perpage:15;
        $rs = array('items' => array(), 'total' => 0);
        $items = $this->getListItems($field,$where, $page, $perpage);
        $total = $this->getListTotal($where);
        $rs['items'] = $items;
        $rs['total'] = $total;
        $rs['page'] = intval($page);
        $rs['psize'] = ceil($total/$perpage);
        return $rs;
    }
    public function getListNoPage($field="*",$where = array(),$perpage = 200) {
        return $this->getORM($this->table)
            ->select($field)
            ->where($where)
            ->limit(0, $perpage)
            ->fetchAll();
    }
    public function getInfo($field="*",$where = array()) {
        return $this->getORM($this->table)
            ->select($field)
            ->where($where)
            ->fetchOne();
    }

}