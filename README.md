# MOSTOP-FREE 免费版

### DEMO 示例
##### http://admin.demo.mostop.cn/

### 项目搭建步骤

### 1、下载项目并切换到项目中
https://www.mostop.cn/product.html

### 2、修改目录权限
##### chown www:www app_backend/runtime/
##### chown www:www app_backend/web/assets/
##### chown www:www app_backend/web/uploads/

### 3、添加 nginx 配置到 nginx 服务器中，注意修改项目名称及路径
##### \_\_DOCUMENT\_\_/free.mostop.cn.public.conf

### 4、创建 utf8、utf8_general_ci 的 mostop_free 数据库并导入数据
##### \_\_DOCUMENT\_\_/mostop_free.sql

### 5、修改数据库连接配置
##### vim common/config/db.php

### 6、绑定开发 hosts
##### 192.168.101.245 admin.free.mostop.cn.public

### 7、访问项目链接地址，完毕！
##### http://admin.free.mostop.cn.public/