# Markdown 开源博客系统

> 一个将Markdown文件发布成博客文章的PHP开源程序

## 使用方法

1. `git clone https://github.com/codekissyoung/markdown-blog.git blog`

1. 在项目根目录`blog/`放置`favicon.ico`作为网站图标

1. 将`Apache`或`Nginx`或者其他`Web服务器`的`域名解析路径`设置成本项目的`web`目录

1. 复制`config.example.php`为`config.php`文件, 然后修改之,可以设置的选项如下:

```php
<?php
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

## Apache服务器配置注意点

- 项目目录要设置成可以访问，并且允许使用`.htaccess`文件

```bash
<Directory /home/user/workspace/>
    Options Indexes FollowSymLinks
    AllowOverride all
    Require all granted
</Directory>
```

- 需要开启URL重写模块

```
sudo a2enmod  rewrite
```

## Nginx Server 配置参考

```bash
server {
    listen 80;
    root /home/cky/workspace/markdown-blog/web;
    index index.php index.html;
    server_name blog.cky.com;
    rewrite_log on;

    location / {
        if ( !-e $request_filename ) {
            rewrite ^/(.*)$ /index.php/$1 last;
            break;
        }
    }

    location ~ \.php($|/) {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 案例

- [Codekissyoung Blog](https://blog.codekissyoung.com/)
- [Cool Blog](http://zj0395.com/)
