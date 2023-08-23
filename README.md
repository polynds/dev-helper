# dev-helper

开发的好助手

##### 安装使用

###### 拉取代码

```shell
git clone https://github.com/polynds/dev-helper.git
```

###### 进入目录

```shell
cd dev-helper
```

###### 安装依赖

```shell
composer install
```

###### 执行权限

```shell
chmod +x dh
```

###### 启动命令行

```shell
./dh
```

##### 贡献插件

##### 自动化创建插件

```bash
./dh createPlugin
```

##### 手动创建插件

- 在src/Plugin下新增插件文件夹
- composer init
- 使用Lib类库提供的功能实现插件
- composer.json中require下新增"devhelper-plugin/plantuml": "dev-main"

##### 由 JetBrains 赞助

非常感谢 Jetbrains 为我提供的 IDE 开源许可，让我完成此项目和其他开源项目上的开发工作。

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/overtrue)