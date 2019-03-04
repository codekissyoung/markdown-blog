<?php

/////////////////////////// 用户自定义配置 //////////////////////////

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

// 博客的自定义链接
$BLOG_CATEGORY_LINK = [
	// 站外链接
	[
		"href"  => "http://www.baidu.com",
		"name"  => "百度一下"
	],

	// 站内链接
	[
		"href"  => "/Linux/epoll",
		"name"  => "epoll教程"
	],
];
/////////////////////////// Blog 系统配置 ///////////////////////////

define("APP_ROOT",__DIR__);
include_once 'function/common.php';   // 公共方法
include_once 'function/autoload.php'; // 自动加载
