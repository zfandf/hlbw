define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

  var Controller = {
    index: function () {
      // 初始化表格参数配置
      Table.api.init({
        extend: {
          index_url: 'order/offline/index',
          edit_url: 'order/offline/edit',
          table: 'order',
        }
      });

      var table = $("#table");

      var typeList = {"1": "鉴证备案", "2": "在线鉴定", "3": "线下鉴定", "4": "评估", "5": "检测", "6": "金融服务"},
          statusList = {"wait": "待支付", "pay": "已支付", "success": "已完成"};

      //当表格数据加载完成时
      table.on('load-success.bs.table', function (e, data) {
        //这里可以获取从服务端获取的JSON数据
        typeList = data.extend.typeList;
        statusList = data.extend.statusList;
      });

      // 初始化表格
      table.bootstrapTable({
        showExport: false,
        url: $.fn.bootstrapTable.defaults.extend.index_url,
        pk: 'id',
        sortName: 'id',
        columns: [
          [
            {field: 'id', title: __('Id'), sortable: true, visible: false},
            {field: 'order_no', title: '订单号'},
            {field: 'type', title: '服务类型', formatter: Table.api.formatter.status, searchList: typeList},
            {field: 'name', title: '名称', operate: 'LIKE'},
            {field: 'category', title: '类别'},
            {field: 'experts.name', title: '专家'},
            {field: 'price', title: '费用(元)', operate: false},
            {
              field: 'offline_time', title: '预约时间',
              formatter: Table.api.formatter.datetime,
              operate: 'RANGE',
              addclass: 'datetimerange',
              sortable: true
            },
            {field: 'offline_contacts', title: '预约人', visible: false},
            {field: 'offline_phone', title: '预约人电话', visible: false},
            {field: 'offline_address', title: '预约人地址', visible: false},
            // {field: 'detail_images', title: '图片', formatter: Controller.api.formatter.detail_images, operate: false},
            {
              field: 'createtime',
              title: '下单时间',
              formatter: Table.api.formatter.datetime,
              operate: 'RANGE',
              addclass: 'datetimerange',
              sortable: true
            },
            {
              field: 'paytime',
              title: '支付时间',
              formatter: Table.api.formatter.datetime,
              operate: 'RANGE',
              addclass: 'datetimerange',
              sortable: true
            },
            {
              field: 'status',
              title: __('Status'),
              formatter: Table.api.formatter.status,
              searchList: statusList
            },
            {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
          ]
        ]
      });

      // 为表格绑定事件
      Table.api.bindevent(table);

      $(document).on("click", ".view-screenshots", function () {
        var data = [];
        data.push({
          "src": $(this).data('url'),
        });
        var json = {
          "title": $(this).attr('original-title'),
          "data": data
        };
        top.Layer.photos(top.JSON.parse(JSON.stringify({photos: json})));
      });
    },
    add: function () {
      Controller.api.bindevent();
    },
    edit: function () {
      Controller.api.bindevent();
    },
    api: {
      formatter: {
        /*detail_images: function (value, row) {
          var str = '';
          var details = row.detail_images.split(',');
          details.forEach(function (value2) {
            str += ' <a href="javascript:;" data-url="' + value2 + '" class="view-screenshots text-success" title="细节图" data-toggle="tooltip">' +
                '<img src="' + value2 + '" width="30" height="30">' +
                '</a>';
          })
          var second = '';
          if (row.side_images) {
            second += ' <a href="javascript:;" data-url="' + row.side_images + '" class="view-screenshots text-success" title="侧面图" data-toggle="tooltip">' +
                '<img src="' + row.side_images + '" width="30" height="30">' +
                '</a>';
          }
          if (row.bottom_images) {
            second += ' <a href="javascript:;" data-url="' + row.bottom_images + '" class="view-screenshots text-success" title="底面图" data-toggle="tooltip">' +
                '<img src="' + row.bottom_images + '" width="30" height="30">' +
                '</a>';
          }
          if (row.preface_images) {
            second += ' <a href="javascript:;" data-url="' + row.preface_images + '" class="view-screenshots text-success" title="题跋图" data-toggle="tooltip">' +
                '<img src="' + row.preface_images + '" width="30" height="30">' +
                '</a>';
          }
          if (row.inscribe_images) {
            second += ' <a href="javascript:;" data-url="' + row.inscribe_images + '" class="view-screenshots text-success" title="落款图" data-toggle="tooltip">' +
                '<img src="' + row.inscribe_images + '" width="30" height="30">' +
                '</a>';
          }
          if (second) {
            str += '<br>' + second;
          }
          return str;
        }*/
      },
      bindevent: function () {
        Form.api.bindevent($("form[role=form]"));
      }
    }
  };
  return Controller;
});