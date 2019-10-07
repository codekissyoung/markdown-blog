<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title><?=$site_title?></title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link href="/css/normalize.css" rel="stylesheet"/>
        <link href="/css/github.css" rel="stylesheet">
        <link href="/css/github-markdown.css" rel="stylesheet">
        <link href="/css/common.css" rel="stylesheet"/>
    </head>
    <body>
        <div id="site-category">
            <div id="site-category-content">
                <div id="blog-name">
                    <a href="/"><?=BLOG_TITLE?></a>
                </div>
                <div id="blog-category-list">
					<?php if(isset($BLOG_CATEGORY_LINK) && !empty($BLOG_CATEGORY_LINK) ): ?>
					<ul>
						<?php foreach( $BLOG_CATEGORY_LINK as $link ): ?>
						<li>
                            <a href="<?=$link['href']?>" target="_blank" >
                                <?=$link['name'] ?>
                            </a>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif;?>
                </div>
                <div id="search-article">
                    <form action="/" method="GET" autocomplete="off">
                    <input type="text" name="search_key" value="<?=$search_key?>" placeholder=""/>
                        <input type="submit" value="搜索" />
                    </form>
                </div>
            </div>
        </div>
