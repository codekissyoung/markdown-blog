<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="baidu-site-verification" content="PVkQXzqbOU" />
        <title><?=$site_title?></title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link href="/css/normalize.css" rel="stylesheet"/>
        <link href="/css/github.css" rel="stylesheet">
        <link href="/css/github-markdown.css" rel="stylesheet">
        <link href="/css/common.css" rel="stylesheet"/>
        <script type='text/javascript'>
        !function(e,t,n,g,i){e[i]=e[i]||function(){(e[i].q=e[i].q||[]).push(arguments)},n=t.createElement("script"),tag=t.getElementsByTagName("script")[0],n.async=1,n.src=('https:'==document.location.protocol?'https://':'http://')+g,tag.parentNode.insertBefore(n,tag)}(window,document,"script","assets.growingio.com/2.1/gio.js","gio");
          gio('init','afb224dd6d58e214', {});
        gio('send');
        </script>
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
							<a href="<?=$link['href']?>" ><?=$link['name'] ?></a>
						</li>
						<?php endforeach; ?>
                        <li>
                           <a href="?upload_img=1">图床</a>
                        </li>
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
