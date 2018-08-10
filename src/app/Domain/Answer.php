<?php
namespace App\Domain;

use App\Model\BaseModel as baseModel;

class Answer extends baseModel{


    public function getListPage($field="*",$where = array() , $page='', $perpage='') {

        $page = $page?$page:I('p')?I('p'):1;
        $perpage = $perpage?$perpage:I('psize')?intval(I('psize')):15;
        $rs = array('items' => array(), 'total' => 0);
        $items = $this->getListItems($where, $page, $perpage);
        $total = $this->getListTotal($where);
        $rs['items'] = $items;
        $rs['total'] = $total;
        $rs['page'] = intval($page);
        $rs['psize'] = ceil($total/$perpage);
        return $rs;
    }

    public function addAnswer($data){
        @$id = $this->add($data);
        if ($i = intval($id['id'])){
            foreach ($data['images'] as $image){
                $this->loadModel('answer_img')->add(array(
                    'image'=>$image['file'],
                    'aid'=>$i
                ));
            }
        }

        return $id['id'];
    }


}
$model = new Answer();