<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:47:"C:\code\hlbw\addons\third\view\index\index.html";i:1544619001;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <title>第三方登录 - <?php echo $site['name']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap Core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/assets/css/frontend.css" rel="stylesheet">

        <!-- Plugin CSS -->
        <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/simple-line-icons@2.4.1/css/simple-line-icons.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="container">
            <h2>第三方登录</h2>
            <hr>
            <div class="well">
                <div class="row">
                    <div class="col-xs-4">
                        <a target="_blank" href="<?php echo addon_url('third/index/connect',[':platform'=>'qq']); ?>" class="btn btn-block btn-info">
                            <i class="fa fa-qq"></i> QQ登录
                        </a>
                    </div>
                    <div class="col-xs-4">
                        <a target="_blank" href="<?php echo addon_url('third/index/connect',[':platform'=>'wechat']); ?>" class="btn btn-block btn-success">
                            <i class="fa fa-wechat"></i> 微信登录
                        </a>
                    </div>
                    <div class="col-xs-4">
                        <a target="_blank" href="<?php echo addon_url('third/index/connect',[':platform'=>'weibo']); ?>" class="btn btn-block btn-danger">
                            <i class="fa fa-weibo"></i> 微博登录
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@2.1.4/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $(function () {

            });
        </script>
    </body>
</html>
