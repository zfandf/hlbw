<?php

namespace app\common\model;

use think\Model;

/**
 * 专家模型
 */
class Articles Extends Model
{
    // 表名
    protected $name = 'articles';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    public static function getInfo($id = NULL)
    {
        return self::where('id', '=', $id)->find();
    }
}
