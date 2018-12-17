<?php

namespace app\common\model;

use think\Model;

/**
 * 轮播图模型
 */
class Banner Extends Model
{
    // 表名
    protected $name = 'banner';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    public static function getArray()
    {
        $list = self::where('status', '=', 'normal')
                    ->order('weigh', 'desc')->select();
        return $list;
    }

    public static function getInfo($id = NULL)
    {
        return self::where('id', '=', $id)->find();
    }
}
