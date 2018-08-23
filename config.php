<?php

/////////////////////////// 用户自定义配置 //////////////////////////

// 博客名称
define("BLOG_TITLE","CodekissYoung Blog");

// markdown文件所在目录
define("MD_ROOT","/home/cky/workspace/md/");

// 博客首页加载的 markdown 文件
define("DEFAULT_ARTICLE",MD_ROOT."link.md");

/////////////////////////// Blog 系统配置 ///////////////////////////

define("APP_ROOT",__DIR__);
include_once 'function/common.php';   // 公共方法
include_once 'function/autoload.php'; // 自动加载
