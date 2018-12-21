<?php

namespace app\common\model;

use think\Model;

/**
 * 服务类型模型
 */
class OrderType Extends Model
{
    // 表名
    protected $name = 'order_type';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = 'updatetime';

    public static function get_list()
    {
        return self::fieldRaw('id as type,name,image,price')->select();
    }

}
