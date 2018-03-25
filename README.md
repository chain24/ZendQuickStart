## ZendFramework 1.x 快速入门 ##

#### 软件环境 ###

PHP 5.1.4 或以上版本，支持 mod_rewrite 功能的 Web 服务器。

####本教程运行环境####

PHP 5.1.4 或以上版本，外加Apache Web 服务器。 Apache 已安装并正确配置了**mod_rewrite** 扩展。保证 **Apache** 已配置成支持**.htaccess** 文件的模式。通常这可以通过在 **httpd.conf** 中将

`AllowOverride None` 改成 `AllowOverride All`

####框架下载####

[http://framework.zend.com/download](http://framework.zend.com/download "zendframe work 官网地址")

####路由重写文件####

ZendQuickStart/public目录下新建**.htaccess** 内容为：

    # Zend Frameworkrewrite 规则

	RewriteEngine on

	RewriteCond%{REQUEST_FILENAME} !-f

	RewriteRule .*index.php
####浏览器访问url####

[http://localhost/ZendQuickStart/public](http://localhost/ZendQuickStart/public/index.php/index/index)

##使用命令行创建项目

	1.cd /d/xampp/htdocs/ZendQuickStart/bin
	
	2.zf.sh create project /d/xampp/htdocs/chainw/ZendQuickStart/,生成application目录。
