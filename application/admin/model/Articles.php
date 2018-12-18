<?php

namespace app\admin\model;

use app\common\model\MoneyLog;
use think\Model;

class Articles extends Model
{

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

    public static function getTypeList() {
        return ['鉴证快讯' => '鉴证快讯', '金融资讯' => '金融资讯'];
    }
}
