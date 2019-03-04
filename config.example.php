<?php

/////////////////////////// 用户自定义配置 //////////////////////////

// 博客名称
define("BLOG_TITLE","Simple Markdown Blog");

// markdown文件所在目录
define("MD_ROOT","/home/user1/workspace/md/");

// 博客首页加载的 markdown 文件,若网站首页需要固定展示某篇博客时，可设置
// $DEFAULT_ARTICLE = MD_ROOT."android/安卓教程.md";

// MD_ROOT 下需要被跳过的文件夹
$IGNORE_DIR = [".git","img","android/java教程"];

// MD_ROOT 下需要被跳过的文件
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
