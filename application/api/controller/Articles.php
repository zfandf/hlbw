<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 专家接口
 */
class Articles extends Api
{

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';
    private $info;

    public function _initialize()
    {
        $id = $this->request->request('id');
        $info = \app\common\model\Articles::getInfo($id);
        if ($info && $info->login == 0) {
            $this->noNeedLogin = ['index'];
        }
        $this->info = $info;
        parent::_initialize();
    }

    /**
     * 专家信息
     * @param int $id ID
     */
    public function index()
    {
        echo $this->info->body;
    }
}
