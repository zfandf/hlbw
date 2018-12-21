<?php

namespace app\admin\model;

use app\common\model\MoneyLog;
use think\Model;

class OrderType extends Model
{

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    public function getOriginData()
    {
        return $this->origin;
    }

    protected static function init()
    {
        self::beforeUpdate(function ($row) {
            $changed = $row->getChangedData();
            //如果有修改密码
            if (isset($changed['password'])) {
                if ($changed['password']) {
                    $salt = \fast\Random::alnum();
                    $row->password = \app\common\library\Auth::instance()
                                                             ->getEncryptPassword($changed['password'],
                                                                 $salt);
                    $row->salt = $salt;
                } else {
                    unset($row->password);
                }
            }
        });


        self::beforeUpdate(function ($row) {
            $changedata = $row->getChangedData();
            if (isset($changedata['money'])) {
                $origin = $row->getOriginData();
                MoneyLog::create([
                    'user_id' => $row['id'],
                    'money' => $changedata['money'] - $origin['money'],
                    'before' => $origin['money'],
                    'after' => $changedata['money'],
                    'memo' => '管理员变更金额'
                ]);
            }
        });
    }
}
