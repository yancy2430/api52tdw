<?php
namespace App\Api;

use PhalApi\Api;
/**
 * 教育云视频
 * User: yangzhe
 * Date: 2017/12/6
 * Time: 09:50
 */
class EduVideo extends BaseApi {
    /**
     * 获取所有的视频列表
     * @desc 通过ID获取所有的列表
     * @return mixed
     */
    public function getList() {
        $data = $this->loadModel('edu_video')->getListPage();

        return $data;
    }


}