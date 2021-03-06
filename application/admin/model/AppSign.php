<?php

namespace app\admin\model;

use app\common\model\MoneyLog;
use think\Model;

class AppSign extends Model
{

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
}
