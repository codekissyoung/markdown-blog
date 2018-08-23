<?php include_once "header.php" ?>
<div id="article">
    <nav id="main_category">
        <div id="main-category-content">
            <?=$category?>
        </div>
    </nav>
    <div id="article-category-button">
        <a  href="javascript:void();">目录</a>
    </div>
    <div id="article-content">
        <div class="markdown-body">
            <?=$html;?>
        </div>
    </div>
</div>
<?php include_once "footer.php" ?>

