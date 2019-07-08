<?php include_once "header.php" ?>

<div id="article">

    <?php include_once "category.php" ?>

    <div id="article-content">
        <div class="markdown-body">
            <?=$html;?>

            <div class="show-upload-img"> 
                <!-- <img src="https://img.codekissyoung.com/2019/07/08/a7510367cb659ebebe9c278a8ead7cb8.png"> --> 
            </div>

            <div class="upload-img-btn">
                <button >上传图片</button>
                <input type="file" id="file"/>
            </div>

            <div class="img-markdown-text">
                <!--
                <div class="markdown-url-input">
                    <input id="foo" value="![深度截图_选择区域_20190708184404.png](https://img.codekissyoung.com/2019/07/08/a7510367cb659ebebe9c278a8ead7cb8.png)">
                    <button class="clipboard-btn" data-clipboard-target="#foo">复制</button>
                </div>
                -->
            </div>

        </div>
    </div>

</div>

<?php include_once "footer.php" ?>
