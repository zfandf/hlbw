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
     * 证书列表
     * @param String $status 状态，wait:预备案, old:已过期, success:已备案
     *
     * @param Int page 页码，默认1
     * @param Int count 每页展示条数，默认20
     */
    public function lists()
    {
        $status = $this->request->request('status');
        if (!$status) {
            $this->error('缺少status参数');
        }
        $where = ['object_cert.status' => $status];
        list($offset, $limit) = $this->getLimits($this->request);
        $list = ObjectCert::get_list($where, $offset, $limit);
        foreach ($list as &$row) {
            $row['name'] = $row['order']['name'];
            $row['valid'] = $row['validtime'] > 0 ? date('Y-m-d',
                $row['validtime']) : '永久';
        }
        $this->success('', $list);
    }

    /**
     * 证书详情
     * @param String $cert_id 证书id
     */
    public function info()
    {
        $cert_id = $this->request->request('cert_id');
        $info = ObjectCert::get($cert_id);
        if (!$info) {
            $this->error('证书不存在');
        }
        $this->success('', $info);
    }
}
