<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\ObjectCert;

/**
 * 证书接口
 */
class Cert extends Api
{

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取预备案号
     */
    public function create_prep_no()
    {
        $user = $this->auth->getUser();
        $prep_no = ObjectCert::build_no();
        $info = ObjectCert::create([
            'user_id' => $user->id,
            'prep_no' => $prep_no
        ]);
        $this->success('', ['cert_id' => $info->id, 'prep_no' => $prep_no]);
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
