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
        $data = \app\common\model\Articles::getListData($offset, $limit);
        $list = $data['list'];
        foreach ($list as $k => &$row) {
            if ($k <= 4) {
                $row['is_new'] = 1;
            } else {
                $row['is_new'] = 0;
            }
            $row['url'] = get_host_name() . '/api/articles/index?id=' . $row->id;
        }
        $data['list'] = $list;
        $this->success('', $data);
    }

}
