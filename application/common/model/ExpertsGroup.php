<?php

namespace app\common\model;

use think\Model;

class ExpertsGroup extends Model
{

    // 表名
    protected $name = 'experts_group';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    public static function getGroupArray($status = NULL)
    {
        $list = collection(self::where(function($query) use($status) {
            if (!is_null($status))
            {
                $query->where('status', '=', $status);
            }
        })->order('weigh', 'desc')->select())->toArray();
        return $list;
    }
}
