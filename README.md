#勤道CMS构建文档
##项目简介
勤道CMS首先是一套基础开发框架，一套极简的内容管理系统CMS  
勤道CMS基于Codeigniter开发。  

##安装
勤道CMS作为一套基础开发框架，为技术人员设计，所以并未提供安装引导程序。  
系统设计的初衷之一就是不增加系统功能实现以外的任何代码，保持勤道CMS的简洁，易用。

###导入数据库
####新建数据库：qdsay  
> CREATE DATABASE IF NOT EXISTS qdsay DEFAULT CHARSET utf8 COLLATE utf8_general_ci;  

创建用户：qdmaster，并为数据库：qdsay 赋予增、删、改、查权限，并设置访问密码：123456  
> GRANT SELECT,INSERT,UPDATE,DELETE  
> ON qdsay.*  
> TO qdmaster@localhost  
> IDENTIFIED BY '123456';  

导入数据库表结构：  
> USE qdsay;  
> SOURCE ./database/qdsay.sql  

####修改数据库配置
> \#vi application/config/database.php  
> \#vi application/backend/config/database.php  
> \#vi application/config/config.php  
> \#vi application/backend/config/config.php  

###文件权限
前台程序入口：qdsay/index.php  
后台程序入口：qdsay/backend/index.php  
####发布版本文件权限
> \#sudo chmod -R 755 qdsay  
> \#sudo chmod -R 777 qdsay/uploads  
> \#sudo chmod -R 777 qdsay/application/cache  
> \#sudo chmod -R 777 qdsay/application/logs  
> \#sudo chmod -R 777 qdsay/application/backend/cache  
> \#sudo chmod -R 777 qdsay/application/backend/logs  

####开发版本目录权限
勤道基础开发框架拥有一个高度自定义的代码生成器
#####前台目录权限
> \#sudo chmod -R 777 qdsay/application/controllers  
> \#sudo chmod -R 777 qdsay/application/models  
> \#sudo chmod -R 777 qdsay/application/views  

#####后台目录权限
> \#sudo chmod -R 777 qdsay/application/backend/controllers  
> \#sudo chmod -R 777 qdsay/application/backend/models  
> \#sudo chmod -R 777 qdsay/application/backend/views  

注：项目发布后，修改上述目录权限为755，如下：
> \#sudo chmod -R 755 qdsay/application/controllers  
> \#sudo chmod -R 755 qdsay/application/models  
> \#sudo chmod -R 755 qdsay/application/views  
> \#sudo chmod -R 755 qdsay/application/backend/controllers  
> \#sudo chmod -R 755 qdsay/application/backend/models  
> \#sudo chmod -R 755 qdsay/application/backend/views  

##脚手架  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/compiled  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/template  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/setup  

###访问：  
> localhost/backend/scaffold  

###配置：
文本：Text
密码：Password
文本域：TextArea
分类：Catalog
下拉选项（DB）：Select-From-DB
下拉选项（Array）：Select-From-Array
单选框（DB）：Radio-From-DB
单选框（Array）：Radio-From-Array
复选框（DB）：CheckBox-From-DB
复选框（Array）：CheckBox-From-Array
开关：Switch
隐藏域：Hidden
上传：Attach
上传预览：Image
组图：Gallery
富文本：Editor
日期：Date
省份：Position-Province
城市：Position-City
区县：Position-District
添加时间：AddTime
禁用：Disabled