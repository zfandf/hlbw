define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'news/objectbest/index',
          add_url: 'news/objectbest/add',
          edit_url: 'news/objectbest/edit',
          del_url: 'news/objectbest/del',
          multi_url: 'news/objectbest/multi',
          table: 'objectbest',
        }
      });

      var table = $("#table");

      // 初始化表格
      table.bootstrapTable({
        url: $.fn.bootstrapTable.defaults.extend.index_url,
        pk: 'id',
        sortName: 'weigh',
        columns: [
          [
            {checkbox: true},
            {field: 'id', title: __('Id')},
            {field: 'title', title: '名字'},
            {field: 'tags', title: '标签'},
            {field: 'age', title: '年代'},
            {field: 'category', title: '类别'},
            {field: 'size', title: '尺寸'},
            {field: 'avatar', title: '主图', formatter: Table.api.formatter.image, operate: false},
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
            {
              field: 'status',
              title: __('Status'),
              formatter: Table.api.formatter.status,
              searchList: {normal: __('Normal'), hidden: __('Hidden')}
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