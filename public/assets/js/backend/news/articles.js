define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'news/articles/index',
                    add_url: 'news/articles/add',
                    edit_url: 'news/articles/edit',
                    del_url: 'news/articles/del',
                    multi_url: 'news/articles/multi',
                    table: 'articles',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'type', title: '资讯类型'},
                        {field: 'title', title: __('Title')},
                        {field: 'description', title: __('Abstract'), operate: 'LIKE'},
                        {field: 'thumbnail', title: __('Thumbnail'), formatter: Table.api.formatter.image, operate: false},
                        {field: 'updatetime', title: __('Update time'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'createtime', title: __('Create time'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status, searchList: {normal: __('Normal'), hidden: __('Hidden')}},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

          //绑定TAB事件
          $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // var options = table.bootstrapTable(tableOptions);
            var typeStr = $(this).attr("href").replace('#','');
            var options = table.bootstrapTable('getOptions');
            options.pageNumber = 1;
            if (typeStr == 'all') {
              options.queryParams = function (params) {
                params.filter = '';
                return params;
              };
            } else {
              options.queryParams = function (params) {
                params.filter = JSON.stringify({type: typeStr});
                return params;
              };
            }

            table.bootstrapTable('refresh', {});
            return false;

          });
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
              $(document).on("change", "#c-type", function () {
                $("#c-pid option[data-type='all']").prop("selected", true);
                $("#c-pid option").removeClass("hide");
                $("#c-pid option[data-type!='" + $(this).val() + "'][data-type!='all']").addClass("hide");
                $("#c-pid").selectpicker("refresh");
              });
              Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});