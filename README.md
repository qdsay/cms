#勤道CMS构建文档
##项目简介
勤道CMS首先是一套基础开发框架，一套极简的内容管理系统CMS  
勤道CMS基于Codeigniter开发。  

##安装

##文件权限
前台程序入口：qdsay/index.php  
后台程序入口：qdsay/backend/index.php  
###发布版本文件权限
> \#sudo chmod -R 755 qdsay  
> \#sudo chmod -R 777 qdsay/uploads  
> \#sudo chmod -R 777 qdsay/application/cache  
> \#sudo chmod -R 777 qdsay/application/backend/cache  

###开发版本目录权限
勤道基础开发框架chu拥有一个高度自定义的代码生成器
####前台目录权限
> \#sudo chmod -R 777 qdsay/application/controllers  
> \#sudo chmod -R 777 qdsay/application/models  
> \#sudo chmod -R 777 qdsay/application/views  

####后台目录权限
> \#sudo chmod -R 777 qdsay/application/backend/controllers  
> \#sudo chmod -R 777 qdsay/application/backend/models  
> \#sudo chmod -R 777 qdsay/application/backend/views  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/compiled  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/template  
> \#sudo chmod -R 777 qdsay/application/backend/scaffold/setup  

项目发布后，修改上述目录权限为755，如下：
> \#sudo chmod -R 755 qdsay/application/controllers  
> \#sudo chmod -R 755 qdsay/application/models  
> \#sudo chmod -R 755 qdsay/application/views  
> \#sudo chmod -R 755 qdsay/application/backend/controllers  
> \#sudo chmod -R 755 qdsay/application/backend/models  
> \#sudo chmod -R 755 qdsay/application/backend/views  
> \#sudo chmod -R 755 qdsay/application/backend/scaffold/template  
> \#sudo chmod -R 755 qdsay/application/backend/scaffold/setup  