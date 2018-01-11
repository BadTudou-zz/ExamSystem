# ExamSystem
## 概述

## 安装
### 服务器要求
* PHP >= 7.0.0
* NodeJs >= 8.6.0
* Composer >= 1.5.2
* Laravel >= 5.5
### 安装依赖 && 初始化 && 运行
1. LINUX

`sh init.sh`

2. Windows

`inti.bat`

或者手动执行下面的**安装依赖**、**初始化**、**运行**。
### 安装依赖
#### 安装依赖的PHP包
`composer install`

#### 安装依赖的Node包
`npm install`

#### 编译、打包前端资源
`npm run environment`

## 初始化
#### 执行数据迁移
`php artisan migrate`

#### 执行数据填充
```
php artisan passport:install
php artisan db:seed
```

## 运行
`php artisan serve`

## 版权
Copyright (c) 2017-2018 www.cqnu.edu.cn
All rights reserved.
