<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\ObjectOrder;
use app\common\model\OrderType;

/**
 * 订单接口
 */
class Order extends Api
{

    protected $noNeedLogin = ['get_types'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取服务类型
     */
    public function get_types()
    {
        return $this->success('', OrderType::get_list());
    }

    /**
     * 下单
     * @praam String $cert_id 证书id，通过 /api/cert/create_prep_no 获得
     * @param String $type 服务类型，根据 /api/order/get_types 中type一致
     * @param String $name 藏品名称
     * @param String $category 藏品类别
     * @param Int $expert_id 专家ID
     *
     * @param String $detail_images 细节图，多个之间逗号分隔
     * @param String $side_images 侧面图
     * @param String $bottom_images 底面图
     * @param String $preface_images 题跋图
     * @param String $inscribe_images 落款图
     *
     * @param String $remark 备注
     *
     * @param Int $is_offline 是否线下预约订单
     * @param String $offline_time 预约时间
     * @param String $offline_contacts 预约人
     * @param String $offline_phone 预约人电话
     * @param String $offline_address 预约地址
     */
    public function order()
    {
        $col = [];
        $col['cert_id'] = $this->request->request('cert_id');
        $col['type'] = $this->request->request('type');
        $col['name'] = $this->request->request('name');
        $col['category'] = $this->request->request('category');
        $col['expert_id'] = $this->request->request('expert_id');
        $col['detail_images'] = $this->request->request('detail_images');
        list($empty, $msg) = checkColEmpty($col);
        if ($empty) {
            $this->error('缺少参数: ' . $msg);
        }
        if (!\app\common\model\ObjectCert::get($col['cert_id'])) {
            $this->error('预备案证书不存在');
        }
        if (!\app\common\model\Experts::get($col['expert_id'])) {
            $this->error('专家不存在');
        }
        $typeInfo = OrderType::get($col['type']);
        if (!$typeInfo) {
            $this->error('服务类别有误');
        }
        $col['price'] = $typeInfo['price'];
        $col['side_images'] = $this->request->request('side_images');
        $col['bottom_images'] = $this->request->request('bottom_images');
        $col['preface_images'] = $this->request->request('preface_images');
        $col['inscribe_images'] = $this->request->request('inscribe_images');
        $col['is_offline'] = $this->request->request('is_offline');
        $col['remark'] = $this->request->request('remark');

        // 线下预约订单
        if ($col['is_offline'] == 1) {
            $offline_time = $this->request->request('offline_time');
            $offline_contacts = $this->request->request('offline_contacts');
            $offline_phone = $this->request->request('offline_phone');
            $offline_address = $this->request->request('offline_address');
            list($empty, $msg) = checkColEmpty([
                $offline_time,
                $offline_contacts,
                $offline_phone,
                $offline_address
            ]);
            if ($empty) {
                $this->error('缺少参数: ' . $msg);
            }
            if (strtotime($offline_time) < (time() + 43200)) {
                $this->error('预约时间必须至少要在12个小时后');
            }
            $col['offline_time'] = $offline_time;
            $col['offline_contacts'] = $offline_contacts;
            $col['offline_phone'] = $offline_phone;
            $col['offline_address'] = $offline_address;
        }

        $user = $this->auth->getUser();
        $col['user_id'] = $user->id;
        $col['order_no'] = ObjectOrder::build_no();
        $res = ObjectOrder::create($col);
        if ($res) {
            $this->success('成功',
                ['order_id' => $res->id, 'order_no' => $col['order_no']]);
        } else {
            $this->error('失败');
        }
    }

    /**
     * 订单详情
     * @param Int $order_id 订单号，自增ID
     */
    public function info()
    {
        $order_id = $this->request->request('order_id');
        $user = $this->auth->getUser();
        $info = ObjectOrder::get_info($order_id);
        if (!$info) {
            $this->error('订单不存在');
        }
        if ($info['user_id'] != $user->id) {
            $this->error('非本人订单');
        }

        $this->success('', $info);
    }

    /**
     * 订单列表
     * @param Int $type 服务类型，和api/order/get_types中type一致
     * @param Int $is_offline 是否线下预约订单，1-线下预约
     * @param String $status 订单状态，wait:待支付, pay:已支付, success:已完成
     *
     * @param Int page 页码，默认1
     * @param Int count 每页展示条数，默认20
     */
    public function order_list()
    {
        $type = $this->request->request('type');
        $is_offline = $this->request->request('is_offline');
        $status = $this->request->request('status');
        $where = [];
        if (in_array($type, [1, 2, 3])) {
            $where['type'] = $type;
        }
        $where['is_offline'] = $is_offline;
        if (!empty($status)) {
            $where['status'] = $status;
        }
        list($offset, $limit) = $this->getLimits($this->request);
        $model = model('ObjectOrder');
        $list = ObjectOrder::get_list($where, $offset, $limit);
        foreach ($list as &$row) {
            $row['expert'] = $row->experts->name;
            unset($row->experts);
        }
        $this->success($model->getLastSql(), $list);
    }
}
