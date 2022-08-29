# dev-helper
开发的好助手

##### 安装使用

```bash
# 目录
git clone https://github.com/polynds/dev-helper.git

cd dev-helper

# 安装依赖
composer install

# 启动命令行
php vendor/dev-helper/bin start
```

##### 贡献插件

```bash
# 在src/Plugin下新增插件文件夹
# composer init
# 使用Lib类库提供的功能实现插件
# composer.json中require下新增"devhelper-plugin/plantuml": "dev-main"
```
