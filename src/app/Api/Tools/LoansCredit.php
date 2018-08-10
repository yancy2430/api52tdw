<?php
namespace App\Api\Tools;

use App\Api\BaseApi;

class LoansCredit extends BaseApi  {

    public function is(){
        $data = $this->loadModel('Loans_Credit')->getsss();
        return $data;
    }
}