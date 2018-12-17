<?php

namespace app\common\model;

use think\Model;

/**
 * 专家模型
 */
class Experts Extends Model
{
    // 表名
    protected $name = 'experts';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    public static function getArray($group_id = NULL)
    {
        $list = collection(self::where(function ($query) use ($group_id) {
            if (!is_null($group_id) && !empty($group_id)) {
                $query->where('group_id', '=', $group_id);
            }
        })->order('weigh', 'desc')->select())->toArray();
        return $list;
    }

    public static function getInfo($id = NULL)
    {
        return self::where('id', '=', $id)->find();
    }
}
