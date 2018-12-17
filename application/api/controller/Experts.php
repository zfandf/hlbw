<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 专家接口
 */
class Experts extends Api
{

    protected $noNeedLogin = ['group', 'lists', 'info'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 专家分组
     */
    public function group()
    {
        $list = \app\common\model\ExpertsGroup::getGroupArray();
        $this->success('', $list);
    }

    /**
     * 专家列表
     * @param int $group_id 分组ID
     */
    public function lists()
    {
        $group_id = $this->request->request('group_id');
        $list = \app\common\model\Experts::getArray($group_id);
        $this->success('', $list);
    }

    /**
     * 专家信息
     * @param int $id ID
     */
    public function info()
    {
        $id = $this->request->request('id');
        $info = \app\common\model\Experts::getInfo($id);
        if ($info) {
            $this->success('', $info);
        } else {
            $this->error('专家不存在');
        }
    }
}
