<?php

namespace app\admin\model;

use app\common\model\MoneyLog;
use think\Model;

class ObjectOrder extends Model
{

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';

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

    public function getTypeList()
    {
        $model = \model('OrderType');
        $list = $model->select();
        $data = [];
        foreach ($list as $row) {
            $data[$row['id']] = $row['name'];
        }
        return $data;
    }

    public function getStatusList()
    {
        return ['wait' => '待支付', 'pay' => '已支付', 'success' => '已完成'];
    }

    public function types()
    {
        return $this->belongsTo('OrderType', 'type', 'id', [], 'LEFT')
                    ->setEagerlyType(0);
    }

    public function experts()
    {
        return $this->belongsTo('Experts', 'expert_id', 'id', [], 'LEFT')
                    ->setEagerlyType(0);
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')
                    ->setEagerlyType(0);
    }
}
