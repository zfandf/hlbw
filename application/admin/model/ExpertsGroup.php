<?php

namespace app\admin\model;

use think\Model;

class ExpertsGroup extends Model
{

    // 表名
    protected $name = 'experts_group';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
}
