# 概述
[ExamSystem](https://github.com/badtudou/examsystem)，在线学习、考试平台
## 功能
* 权限控制
* 消息通知
* 组织管理
* 课程管理
* 批量导入题目
* 批量导入用户
* 批量批改试卷
* 自动生成试卷
* 自动答案解析
* 课程讨论
* 获取学习资源
* 考试时实时的视频监控
* ......

## 默认信息
### 默认端口
```
WWW: 80/443
数据库: 3306
Php-fpm: 9000
WebSocket: 8000
```
### 默认数据库

```
地址: 127.0.0.1
端口: 3306
用户名: root
密码: root
```

## 默认用户

```
角色：管理员
用户名：admin@email.com
密码：admin
```

# 安装
## 服务器要求
* SSL证书
* 邮件服务器
* PHP >= 7.0.0
* NodeJs >= 8.6.0
* Composer >= 1.5.2
* Laravel >= 5.5

## 系统安装(基于Docker)
### 构建Docker容器
1. 根据当前操作系统安装合适的 `docker`及`docker-compose`
2. 克隆基于`docker`构建的[Nginx+Php-fpm+MariaDb](https://github.com/badtudou/docker)镜像：
  `git clone https://github.com/BadTudou/docker.git`
3. `docker`目录下执行： `docker-compose build `
4. `docker`目录下执行： `docker-compose up -d`

(若出现端口冲突，请更改`docker/docker-compose.yml`有关配置)

### 在Docker中部署应用
1. 下载项目源码。在`docker/Nginx/www`下执行 `git clone https://github.com/BadTudou/ExamSystem`(建议使用develop分支)
2. 将`SSL`证书复制到 `docker/Nginx/conf/ssl` 目录
3. 将 `docker/Nginx/conf/conf.d/default.conf` 复制为 `www.example.com.conf`，并修改以下配置项：
```
    root         /usr/share/nginx/html/ExamSystem/public;
    ssl on;
    ssl_certificate "/etc/pki/nginx/网站证书.crt";
    ssl_certificate_key "/etc/pki/nginx/网站私有密钥.key";

    location / {
           try_files $uri $uri/ /index.php?$query_string;

    }

    location ~ \.php$ {
        fastcgi_pass   phpfpm:9000;
        fastcgi_index  index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
```
4. 连接数据库服务器并新建数据库`ExamSystem`，
5. 配置项目。复制 `docker/Nginx/www/ExamSystem/.env.example`为`.env`，并修改以下配置项：
```
    # 项目有关配置
    * APP_URL

    # 数据库，请参阅 https://laravel.com/docs/5.6/database，以下配置基于Docker
    * DB_CONNECTION=mysql
    * DB_HOST=db
    * DB_PORT=3306
    * DB_DATABASE=ExamSystem
    * DB_USERNAME=root
    * DB_PASSWORD=root

    # 邮箱，请参阅 Laravel邮箱有关配置
    * MAIL_DRIVER
    * MAIL_HOST
    * MAIL_PORT
    * MAIL_USERNAME
    * MAIL_PASSWORD
    * MAIL_ENCRYPTION
    * MAIL_FROM_ADDRESS
    * MAIL_FROM_NAME

    # Socket，请参阅 https://github.com/orchidsoftware/web-socket
    SOCKET_HTTP_HOST
    SOCKET_PORT
    SOCKET_PUBLIC_PORT
    SOCKET_ADDRESS

    # Laravel Debugbar
    DEBUGBAR_ENABLED=false
```
6. 安装依赖、初始化 、运行

  执行： `docker exec -it docker_phpfpm_1 bash`，进入容器后执行 `/usr/share/nginx/html/ExamSystem/init.sh`，待项目运行后，结束该脚本

    退出容器，在`docker/Nginx/www/ExamSystem`下执行：`npm install && npm run dev `

7. 启动`WebSocket`服务

  执行： `docker exec -it docker_phpfpm_1 bash`，进入容器后切换到 `/usr/share/nginx/html/ExamSystem`，之后执行`php artisan socket:serve &`

# 其他
1. 默认情况下，项目基于`Docker`进行构建、部署，相关维护操作请参阅`Docker`有关文档
2. 项目采用`Https`协议的情况下，前端连接`WebSocket`时需由`ws`协议更改为`wss`协议
3. 非`Docker`环境下，根据实际情形更改Web服务器、数据库 的有关配置即可