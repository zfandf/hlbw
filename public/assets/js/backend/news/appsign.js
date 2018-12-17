define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'news/appsign/index',
          add_url: 'news/appsign/add',
          edit_url: 'news/appsign/edit',
          del_url: 'news/appsign/del',
          multi_url: 'news/appsign/multi',
          table: 'appsign',
        }
      });

      var table = $("#table");

      // 初始化表格
      table.bootstrapTable({
        url: $.fn.bootstrapTable.defaults.extend.index_url,
        pk: 'id',
        sortName: 'id',
        columns: [
          [
            {checkbox: true},
            {field: 'id', title: __('Id')},
            {field: 'sign', title: 'APP识别标记'},
            {field: 'description', title: '描述'},
            {
              field: 'updatetime',
              title: __('Update time'),
              formatter: Table.api.formatter.datetime,
              operate: 'RANGE',
              addclass: 'datetimerange',
              sortable: true
            },
            {
              field: 'createtime',
              title: __('Create time'),
              formatter: Table.api.formatter.datetime,
              operate: 'RANGE',
              addclass: 'datetimerange',
              sortable: true
            },
            {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
          ]
        ]
      });

      // 为表格绑定事件
      Table.api.bindevent(table);
    },
    add: function () {
      Controller.api.bindevent();
    },
    edit: function () {
      Controller.api.bindevent();
    },
    api: {
      bindevent: function () {
        Form.api.bindevent($("form[role=form]"));
      }
    }
  };
  return Controller;
});