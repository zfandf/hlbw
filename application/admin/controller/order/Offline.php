<?php

namespace app\admin\controller\order;

use app\admin\model\ObjectOrder;
use app\common\controller\Backend;

/**
 * 专家管理
 *
 * @icon fa fa-user
 */
class Offline extends Backend
{

    protected $relationSearch = true;


    /**
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ObjectOrder');
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model->with(['experts', 'types'])
                                 ->where($where)
                                 ->where('is_offline', 1)
                                 ->order($sort, $order)
                                 ->count();
            $list = $this->model->with(['experts', 'types'])
                                ->where($where)
                                ->where('is_offline', 1)
                                ->order($sort, $order)
                                ->limit($offset, $limit)
                                ->select();
            $result = array(
                "total" => $total,
                "rows" => $list,
                "extend" => [
                    'typeList' => $this->model->getTypeList(),
                    'statusList' => $this->model->getStatusList()
                ]
            );

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row) $this->error(__('No Results were found'));
        $images = [];
        foreach (explode(',', $row['detail_images']) as $img) {
            $images[] = ['title' => '细节图', 'url' => $img];
        }
        if ($row['side_images']) {
            $images[] = ['title' => '侧面图', 'url' => $row['side_images']];
        }
        if ($row['bottom_images']) {
            $images[] = ['title' => '底面图', 'url' => $row['bottom_images']];
        }
        if ($row['preface_images']) {
            $images[] = ['title' => '题跋图', 'url' => $row['preface_images']];
        }
        if ($row['inscribe_images']) {
            $images[] = ['title' => '落款图', 'url' => $row['inscribe_images']];
        }

        $this->view->assign('images', $images);
        $this->view->assign('statusList', $this->model->getStatusList(),
            $row['status'], ['class' => 'form-control selectpicker']);
        $this->view->assign('typeList', $this->model->getTypeList(),
            $row['type'], ['class' => 'form-control selectpicker']);
        return parent::edit($ids);
    }
}
