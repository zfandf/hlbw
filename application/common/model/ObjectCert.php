<?php

namespace app\common\model;

use think\Model;

/**
 * 证书模型
 */
class ObjectCert Extends Model
{
    // 表名
    protected $name = 'object_cert';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    public static function build_no()
    {
        $no = date("Ymd", time()) . mt_rand(1111, 9999);
        if (self::get(['prep_no' => $no])) {
            return self::build_no();
        }
        return $no;
    }

    public static function get_list($where, $offset, $limit)
    {
        return self::with('order')
                   ->where($where)
                   ->order('createtime', 'desc')
                   ->limit($offset, $limit)
                   ->select();
    }

    public function order()
    {
        return $this->belongsTo('ObjectOrder', 'id', 'cert_id', [], 'LEFT')
                    ->setEagerlyType(0);
    }
}
