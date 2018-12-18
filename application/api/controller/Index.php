<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功');
    }

    /**
     * banner
     */
    public function banner()
    {
        $list = \app\common\model\Banner::getArray();
        $this->success('', $list);
    }

    /**
     * 资讯列表
     * @param Int page 页码，默认1
     * @param Int count 每页展示条数，默认20
     */
    public function news()
    {
        list($offset, $limit) = $this->getLimits($this->request);
        $list = \app\common\model\Articles::getListData($offset, $limit);
        foreach ($list as $k => &$row) {
            if ($k <= 4) {
                $row['is_new'] = 1;
            } else {
                $row['is_new'] = 0;
            }
            $row['url'] = get_host_name() . '/api/articles/index?id=' . $row->id;
        }
        $this->success('', $list);
    }

    /**
     * 艺术品金融服务
     * @param Int page 页码，默认1
     * @param Int count 每页展示条数，默认20
     */
    public function art_finance()
    {
        $list = \app\common\model\Articles::getArtFinanceData();
        foreach ($list as $k => &$row) {
            $row['url'] = get_host_name() . '/api/articles/index?id=' . $row->id;
        }
        $this->success('', $list);
    }

    /**
     * 精品展示
     */
    public function object_best()
    {
        list($offset, $limit) = $this->getLimits($this->request);
        $data = \app\common\model\ObjectBest::getListData($offset, $limit);
        $this->success('', $data);
    }
}
