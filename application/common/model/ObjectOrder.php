<?php

namespace app\common\model;

use think\Model;

/**
 * 服务订单模型
 */
class ObjectOrder Extends Model
{
    // 表名
    protected $name = 'object_order';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = '';

    public function cert()
    {
        return $this->belongsTo('ObjectCert', 'cert_id', 'id', [], 'LEFT')
                    ->setEagerlyType(0);
    }

    public function experts()
    {
        return $this->belongsTo('Experts', 'expert_id', 'id', [], 'LEFT')
                    ->setEagerlyType(0);
    }

    public static function get_info($order_id)
    {
        $info = self::with(['experts', 'cert'])->where([
            'object_order.id' => $order_id
        ])->find();
        $info['order_id'] = $info['id'];
        $info['prep_no'] = $info['cert']['prep_no'];
        $info['expert'] = $info['experts']['name'];
        unset($info['cert']);
        unset($info['experts']);
        return $info;
    }

    public static function get_list($where, $offset, $limit)
    {
        return self::with('experts')
                   ->where($where)
                   ->order('createtime', 'desc')
                   ->limit($offset, $limit)
                   ->select();
    }

    /**
     * 根据当前时间获取一个订单号
     *
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function build_no()
    {
        $no = date("YmdHis", time()) . mt_rand(11111, 99999);
        if (self::get(['order_no' => $no])) {
            return self::build_no();
        }
        return $no;
    }
}
