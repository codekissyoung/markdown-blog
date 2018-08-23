# Markdown 开源博客系统

> 一个将Markdown文件发布成博客文章的PHP开源程序

## 使用方法

1. `git clone` 本项目到你的`Linux`服务器
1. 将`Apache`或`Nginx`或者其他`Web服务器`的`域名解析路径`设置成本项目的`web`目录
1. 复制`config.example.php`为`config.php`文件, 然后修改之,可以设置的选项如下:
1. 在本项目根目录新建一个`favicon.ico`文件为自己的图标文件

```php
// 博客名称
define("BLOG_TITLE","CodekissYoung Blog");

// markdown文件所在目录
define("MD_ROOT","/home/cky/workspace/md/");

// 博客首页加载的 markdown 文件
define("DEFAULT_ARTICLE",MD_ROOT."link.md");

// markdown目录下需要被跳过的文件夹
$IGNORE_DIR = [".git","img","android/java教程"];

// markdown目录下需要被跳过的文件
$IGNORE_FILE = ["link","default","xxx_dir/xxx_dir/file_name"];
```

## 案例

- [Codekissyoung Blog](https://blog.codekissyoung.com/)
