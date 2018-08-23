<?php
include_once '../config.php';
$host         = $_SERVER["HTTP_HOST"];

$protocol = 'http://';
if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
    $protocol = 'https://';
if( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    $protocol = 'https://';

$current_article = isset($_SERVER['PATH_INFO']) ? $_SERVER["PATH_INFO"] : '';
$article = DEFAULT_ARTICLE;
if( $current_article )
    $article = MD_ROOT."{$current_article}.md";

$title  = trim(join('-',explode("/",$current_article))."-".BLOG_TITLE,'-');

// 加载文章内容
$parser  = new HyperDown\Parser();
$content = is_file( $article  ) ? file_get_contents( $article ) : "文章不存在";
$html    = $parser -> makeHtml( $content );

// 搜索全文
$search_key = isset($_GET['search_key']) ? $_GET['search_key'] : '';
if( $search_key )
{
    $html = "";
    $last_search_article = "";
    $li = "";
    exec( "grep -ir \"$search_key\" ".MD_ROOT." | grep -v \`\`\`", $ret_arr, $ret_code );
    if( !empty($ret_arr) )
    {
        foreach( $ret_arr as $key => $value )
        {
            $ret            = explode(".md:",$value);
            $href           = str_replace(MD_ROOT,"",$ret[0]);
            $value          = htmlentities( $ret[1] );
            $value          = str_ireplace( $search_key ,'<span class=search_key>'.$search_key.'</span>', $value );
            $li             = $li."<li class=search-list> $value </li>";

            if( $last_search_article != $href )
            {
                $html  = $html."<h2><a href='$protocol$host/$href'>$href</a></h2>";
                $html  = $html."<lu>".$li."</ul>";

                $li = "";
                $last_search_article = $href;
            }
        }
    }
    else
    {
        $html = "未能搜索到 <span class=search_key>".$search_key."</span>";
    }
}

// 视图
if( isset($_GET['ajax']) )
    include_once 'view/article.php';
else
{
    $category = file_tree_print( file_tree( MD_ROOT ) , $current_article );
    include_once 'view/index.php';
}

