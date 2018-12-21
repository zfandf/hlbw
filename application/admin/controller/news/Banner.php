<?php

namespace app\admin\controller\news;

use app\common\controller\Backend;

/**
 * 专家管理
 *
 * @icon fa fa-user
 */
class Banner extends Backend
{

    /**
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Banner');
        $this->view->assign('signList', build_select('row[sign]', \app\admin\model\AppSign::column('sign,desc'), ['class' => 'form-control selectpicker']));
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
            $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            $result = array("total" => $total, "rows" => $list);

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
        if (!$row)
            $this->error(__('No Results were found'));
        $this->view->assign('signList', build_select('row[sign]', \app\admin\model\AppSign::column('sign,desc'), $row['sign'], ['class' => 'form-control selectpicker']));
        return parent::edit($ids);
    }

}
