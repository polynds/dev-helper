<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Plugin\GenerateDirTree;

use DevHelper\Lib\File\FileFinder;

class GenerateDirTree
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function generate(): void
    {
        $finder = new FileFinder();
        $files = $finder->tree2($this->path);
        $result = $this->show($files);
        echo implode('', $result);
    }

    protected function show(array $files, int $depth = 0): array
    {
        if (empty($files)) {
            return $files;
        }
        $result = [];
        $flags = str_repeat("  ", max($depth, 0));
        $index = 0;
        $count = count($files);
        foreach ($files as $dir => $items) {
            $index++;
            if ($index == $count) {
                $slug = '└── ';
            } else {
                $slug = '├── ';
            }
            if (is_numeric($dir)) {
                $result[] = $flags . $slug . $items . PHP_EOL;
            } else {
                if (is_array($items)) {
                    $result[] = $flags . $slug . $dir . PHP_EOL;
                    $result = array_merge_recursive($result, $this->show($items, ++$depth));
                }
            }
        }

        return $result;
    }


    public function showMD()
    {
        echo <<<'md'

```
.
├── app
│  ├── core-------------------------------------------- 核心应用目录
│  │  ├── chat-tool----------------------------------- 聊天侧边栏
│  │  ├── common-------------------------------------- 公共
│  │  ├── corp---------------------------------------- 企业
│  │  ├── index--------------------------------------- 首页
│  │  ├── install------------------------------------- 安装
│  │  ├── medium-------------------------------------- 媒体库
│  │  ├── official-account---------------------------- 公众号
│  │  ├── rbac---------------------------------------- RBAC权限
│  │  ├── tenant-------------------------------------- 租户
│  │  ├── user---------------------------------------- 用户
│  │  ├── work-agent---------------------------------- 企微应用
│  │  ├── work-contact-------------------------------- 客户
│  │  ├── work-department----------------------------- 部门
│  │  ├── work-employee------------------------------- 员工
│  │  ├── work-message-------------------------------- 消息
│  │  └── work-room----------------------------------- 客户群
│  └── utils------------------------------------------- 工具类
├── plugin
│  └── mochat------------------------------------------ 官方插件目录
│      ├── auto-tag------------------------------------ 自动打标签插件
│      ├── channel-code-------------------------------- 渠道活码插件
│      ├── contact-batch-add--------------------------- 批量添加好友插件
│      ├── contact-message-batch-send------------------ 批量发送客户消息插件
│      ├── contact-sop--------------------------------- 个人SOP插件
│      ├── contact-transfer---------------------------- 在职转接&离职继承插件
│      ├── greeting------------------------------------ 个人欢迎语插件
│      ├── lottery------------------------------------- 抽奖活动插件
│      ├── radar--------------------------------------- 雷达插件
│      ├── room-auto-pull------------------------------ 自动拉群插件
│      ├── room-calendar------------------------------- 群日历插件
│      ├── room-clock-in------------------------------- 群打卡插件
│      ├── room-fission-------------------------------- 群裂变插件
│      ├── room-infinite-pull-------------------------- 无限拉群插件
│      ├── room-message-batch-send--------------------- 批量发送群消息插件
│      ├── room-quality-------------------------------- 群聊质检
│      ├── room-remind--------------------------------- 群提醒
│      ├── room-sop------------------------------------ 群SOP
│      ├── room-tag-pull------------------------------- 标签拉群
│      ├── room-welcome-------------------------------- 群欢迎语插件
│      ├── sensitive-word------------------------------ 敏感词管理&监控插件
│      ├── shop-code----------------------------------- 门店活码
│      ├── statistic----------------------------------- 统计分析插件
│      └── work-fission-------------------------------- 企微里裂变
├── public
├── bin
├── composer.json
├── composer.lock
├── config
├── docker-compose.sample.yml
├── docker-entrypoint.sh
├── Dockerfile
├── migrations
├── package.json
├── phpstan.neon
├── phpunit.xml
├── README.MD
├── runtime
├── seeders
├── storage
├── test
└── vendor
```
md;
    }

}
