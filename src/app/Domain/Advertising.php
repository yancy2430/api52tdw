<?php
namespace App\Domain;

use App\Model\BaseModel as baseModel;

class Advertising extends baseModel
{

    /**
     * 发布信息信息
     * @param $data
     * @return mixed
     */
    public function addAD($data = array()){

        @$id = $this->add($data);
        if ($i = intval($id['id'])){
            if (isset($data['images'])){
                foreach ($data['images'] as $image){
                    $this->loadModel('answer_img')->add(array(
                        'image'=>$image['file'],
                        'aid'=>$i
                    ));
                }
            }
        }

        return $id['id'];
    }
}
$model = new Advertising();