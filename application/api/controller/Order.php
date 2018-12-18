<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 订单接口
 */
class Order extends Api
{

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 下单
     * @param String $name 藏品名称
     * @param String $category 藏品类别
     * @param Int $expert_id 专家ID
     * @param double $price 价格，最多保留两位小数，比如100.20
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
        $user = $this->auth->getUser();

        $type = $this->request->request('type');
        $name = $this->request->request('name');
        $category = $this->request->request('category');
        $expert_id = $this->request->request('expert_id');
        $price = $this->request->request('price');
        $detail_images = $this->request->request('detail_images');
        $side_images = $this->request->request('side_images');
        $bottom_images = $this->request->request('bottom_images');
        $preface_images = $this->request->request('preface_images');
        $inscribe_images = $this->request->request('inscribe_images');
        $is_offline = $this->request->request('is_offline');
        $offline_time = $this->request->request('offline_time');
        $offline_contacts = $this->request->request('offline_contacts');
        $offline_phone = $this->request->request('offline_phone');
        $offline_address = $this->request->request('offline_address');

        $remark = $this->request->request('remark');
        $res = $this->request->ch();
        $this->success('', [$res]);
    }
}
