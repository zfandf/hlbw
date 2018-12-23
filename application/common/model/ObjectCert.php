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

    public static function build_no() {
        $no = date("Ymd", time()) . mt_rand(1111, 9999);
        if (self::get(['prep_no' => $no])) {
            return self::build_no();
        }
        return $no;
    }

    public static function getInfo($id = NULL)
    {
        return self::where('id', '=', $id)->find();
    }
}
