define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'order/type/index',
          edit_url: 'order/type/edit',
          table: 'type',
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
            {field: 'id', title: __('Id'), sortable: true},
            {field: 'name', title: '名称', operate: 'LIKE'},
            {field: 'price', title: '费用', operate: 'LIKE'},
            {field: 'image', title: '图片', formatter: Table.api.formatter.image, operate: false},
            {
              field: 'updatetime',
              title: '修改时间',
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