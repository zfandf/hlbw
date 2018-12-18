<?php

namespace app\common\model;

use think\Model;

/**
 * 专家模型
 */
class ObjectBest Extends Model
{
    // 表名
    protected $name = 'object_best';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    public static function getListData($offset = 0, $limit = 20)
    {
        $list = self::where('status', '=', 'normal')
                    ->order('weigh', 'desc')
                    ->order('updatetime', 'desc')
                    ->limit($offset, $limit)
                    ->select();

        return $list;
    }
}
