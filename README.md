基于 FastAdmin 后台。

* 安装全局 bower 
````npm install bower -g
````

* 下载前端插件依赖包
```` 
bower install
```` 

* 下载PHP依赖包，先切换配置到国内源
```` 
composer config -g repo.packagist composer https://packagist.laravel-china.org
composer install
```` 

* 一键创建数据库并导入数据
````
php think install -u 数据库用户名 -p 数据库密码
````

* 添加虚拟主机并绑定到code/public目录

# 生成API文档
````
//一键生成API文档
php think api -u http://www.hlbw.com  -o apidocs.html --force=true
//指定https://www.example.com为API接口请求域名,默认为空
php think api -u https://www.example.com --force=true
//输出自定义文件为myapi.html,默认为api.html
php think api -o myapi.html --force=true
//修改API模板为mytemplate.html，默认为index.html
php think api -e mytemplate.html --force=true
//修改标题为FastAdmin,作者为作者
php think api -t FastAdmin -a Karson --force=true
//查看API接口命令行帮助
php think api -h
````