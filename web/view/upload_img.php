<?php include_once "header.php" ?>

<div id="article">

    <?php include_once "category.php" ?>

    <div id="article-content">
        <div class="markdown-body">
            <?=$html;?>

            <div class="show-upload-img"></div>

            <div class="upload-img-btn">
                <button >上传图片</button>
                <input type="file" id="file"/>
            </div>

            <div class="img-markdown-text"></div>

        </div>
    </div>

</div>

<?php include_once "footer.php" ?>
