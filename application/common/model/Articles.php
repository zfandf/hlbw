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
        $list = self::where('status', '=', 'normal')
                    ->where($where)
                    ->order('weigh', 'desc')
                    ->order('updatetime', 'desc')
                    ->limit($offset, $limit)
                    ->field('id,title,thumbnail,desc,createtime')
                    ->select();
        return $list;
    }

    public static function getArtFinanceData()
    {
        $where = ['type' => '金融资讯'];
        $list = self::where('status', '=', 'normal')
                    ->where($where)
                    ->order('weigh', 'desc')
                    ->order('updatetime', 'desc')
                    ->field('id,title')
                    ->select();

        return $list;
    }
}
