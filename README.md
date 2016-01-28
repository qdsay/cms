#勤道CMS构建文档  
勤道CMS不仅是一套极简的内容管理系统，还是一套基础的PHP开发框架，他涵盖了我们日常开发中最常用的基础类库。与此同时，勤道CMS还提供了一套高可配置的脚手架程序（代码生成器），用于快速构建内容管理系统中的CRUD程序。  

不同于其他自动化代码生成器，多数情况下，由勤道脚手架构建的CRUD程序，并不需要我们作过多的修改，即可完全用于线上发布。在保证代码一致性的同时，提供了涵盖视图层，控制器层双层输入检查，并不含任何与系统功能实现以外的无效代码。

##项目简介
勤道CMS基于Codeigniter 2.0 开发，由勤道项目组维护，一直作为内部基础开发框架使用。  
随着CI 3.0的发布，勤道CMS迁移至CI 3.0，并于2016年1月18日正式开源。  

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

##二次开发
勤道CMS作为一套开发框架将很容易在此进出之上进行程序扩展，
###建立数据库表  
如需要使用脚手架CRUD程序，请使用如下数据库基础表结构。并为每张表和每个字段添加COMMENT。  

###数据库基础表结构
> CREATE TABLE `qd_table_name` (  
>   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  
>   `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  
>   `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',  
>   PRIMARY KEY (`id`),  
>   KEY `fk_addtime` (`addtime`),  
>   KEY `fk_uptime` (`uptime`)  
> ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文章';  

##脚手架的使用  
勤道CMS基础开发框架拥有一套高度自定义的代码生成器（脚手架），程序会按照配置规则自动生成初始化程序  
所以我们需要赋予上述目录写权限，项目发布前，移除脚手架程序后发布上线。  

###与脚手架相关的程序文件
> qdsay/application/backend/scaffold/  
> qdsay/application/backend/controllers/Scaffold.php  
> qdsay/application/backend/models/Scaffold_model.php  
> qdsay/application/backend/libraries/Template.php  

###配置  
####设置脚手架目录访问权限  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/compiled  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/template  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/setup  

####访问-程序入口地址：  
> localhost/backend/scaffold  

####配置字段输入类型与输入方式：
> 文本框：Text  
> 密码输入框：Password  
> 文本域：TextArea  
> 树状分类菜单组件：Catalog  
> 下拉选项（DB）：Select-From-DB  
> 下拉选项（Array）：Select-From-Array  
> 单选框（DB）：Radio-From-DB  
> 单选框（Array）：Radio-From-Array  
> 复选框（DB）：CheckBox-From-DB  
> 复选框（Array）：CheckBox-From-Array  
> 开关：Switch  
> 隐藏域：Hidden  
> 上传组件：Attach  
> 上传预览组件：Image  
> 相册组件：Gallery  
> 富文本编辑框：Editor  
> 日期组件：Date  
> 省市区三级联动（省份）：Position-Province  
> 省市区三级联动（城市）：Position-City  
> 省市区三级联动（区县）：Position-District  
> 是否启用：Enabled  
> 添加时间：AddTime  
