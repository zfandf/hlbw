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

    public static function getListData($offset = 0, $limit = 10)
    {
        $where = ['type' => '鉴证快讯'];
        $total = self::where('status', '=', 'normal')->where($where)->count();
        $list = self::where('status', '=', 'normal')
                    ->where($where)
                    ->order('weigh', 'desc')
                    ->order('updatetime', 'desc')
                    ->limit($offset, $limit)
                    ->field('id,title,thumbnail,description,createtime')
                    ->select();

        return ['list' => $list, 'total' => $total];
    }

    public static function getArtFinanceData()
    {
        $where = ['type' => '金融资讯'];
        $total = self::where('status', '=', 'normal')->where($where)->count();
        $list = self::where('status', '=', 'normal')
                    ->where($where)
                    ->order('weigh', 'desc')
                    ->order('updatetime', 'desc')
                    ->field('id,title')
                    ->select();

        return ['list' => $list, 'total' => $total];
    }
}
