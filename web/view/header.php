<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="baidu-site-verification" content="PVkQXzqbOU" />
        <title><?=$title?></title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link href="/css/normalize.css" rel="stylesheet"/>
        <link href="/css/github.css" rel="stylesheet">
        <link href="/css/github-markdown.css" rel="stylesheet">
        <link href="/css/common.css" rel="stylesheet"/>
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/highlight.pack.js"></script>
        <script src="/js/main.js"></script>
    </head>
    <body>
        <div id="site-category">
            <div id="site-category-content">
                <div id="blog-name">
                    <a href="/"><?=BLOG_TITLE?></a>
                </div>
                <div id="blog-category-list">
                    <!-- <a href="/img.php">图片库</a> -->
                </div>
                <div id="search-article">
                    <form action="/" method="GET" autocomplete="off">
                    <input type="text" name="search_key" value="<?=$search_key?>" placeholder=""/>
                        <input type="submit" value="搜索" />
                    </form>
                </div>
            </div>
        </div>
        <div id="site-category-box-fill"></div>
