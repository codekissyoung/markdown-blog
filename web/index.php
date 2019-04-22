<?php
include_once '../config.php';
$parser  	  = new HyperDown\Parser();
$host         = $_SERVER["HTTP_HOST"];

$protocol = 'http://';
if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
    $protocol = 'https://';
if( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    $protocol = 'https://';

$current_article = isset($_SERVER['PATH_INFO']) ? $_SERVER["PATH_INFO"] : '';
$title  = trim(join('-',explode("/",$current_article))."-".BLOG_TITLE,'-');

// 加载url里路径指明的文章
if( $current_article )
{
    $article = MD_ROOT."{$current_article}";
}
// 首页加载默认的自定义文章
elseif( isset( $DEFAULT_ARTICLE ) && !empty( $DEFAULT_ARTICLE ) )
{
	$article = $DEFAULT_ARTICLE;
}
// 加载文章列表
else
{
	$article = '';
}

$content = "";
$html = "";


// 首页
if( !isset($article) || empty($article) ) 
{
    $html .= "<h1>最新文章</h1>";
	$list_dir = MD_ROOT;
}
// 访问目录
elseif( is_dir( $article ) )
{
	$html .= "<h1>文章列表</h1>";
	$list_dir = $article;
}
// 访问某篇文章
elseif( is_file( $article.".md" ) )
{
	$content = file_get_contents( $article.".md" );
	$html    = $parser -> makeHtml( $content );
}

if( isset($list_dir) && !empty($list_dir) )
{
	$md_file_list = [];
	$md_file_list = file_list( $list_dir, $md_file_list );
	$md_file_list = sort_file_list( $md_file_list );
	$i = 0;
	foreach( $md_file_list as $file )
	{
        if( substr( $file['path'], -3 ) != ".md" ) 
            continue;
        $ret       = explode( ".md", $file['path'] );
        $href      = str_replace( MD_ROOT, "", $ret[0] );
		$paths = explode( "/", $href );
		$cnt = count( $paths );
		$article_name = $paths[ $cnt - 1 ];
		$semantic_time = semantic_time( $file['time'] );
		$html     .= "<h2><a href='$protocol$host/$href'>$article_name</a> <span class=article-create-time> {$semantic_time}更新</span></h2>";

		if( $i < 50 )
		{
			$content 	    = file_get_contents( $file['path'] );
			$content_parsed = $parser -> makeHtml( $content );
			$text = preg_replace( "/<h1>.*<\/h1>/m","", $content_parsed );
			$text = preg_replace( "/<h2>.*/s","", $text );

			if( strlen($text) > 300 )
			{
				$text = preg_replace( "/<pre>.*/s","", $text );
			}

			if( strlen($text) == 0 )
				$text = "<p>文章无缩略内容。</p>";

			$html .= $text;
			$i++;
		}
	}

}

// 搜索全文
$search_key = isset($_GET['search_key']) ? $_GET['search_key'] : '';
if( $search_key )
{/*{{{*/
    $html 	   = "<h1>搜索结果</h1>";
    $last_h2   = "";
    $li_list   = "";
    exec( "grep -ir --include *.md --exclude-dir='.git' \"$search_key\" ".MD_ROOT." | grep -v \`\`\`", $ret_arr, $ret_code );
    if( !empty($ret_arr) )
    {
        foreach( $ret_arr as $key => $value )
        {
            $ret            = explode(".md:",$value);
            $href           = str_replace(MD_ROOT,"",$ret[0]);
            $value          = str_ireplace( $search_key ,'<span class=search_key>'.$search_key.'</span>', htmlentities( $ret[1] ) );
            $li 			= "<li class=search-list> $value </li>";
			$h2             = "<h2><a href='$protocol$host/$href'>$href</a></h2>";
			$li_list 	   .= $li;

			if( $h2 != $last_h2 )
				$html   .= $h2;

			$last_h2 = $h2;
			$html .= $li;
        }
    }
    else
    {
        $html = "未能搜索到 <span class=search_key>".$search_key."</span>";
    }
}/*}}}*/

// 视图
if( isset( $_GET['ajax'] ) )
    include_once 'view/article.php';
else
{
    $category = file_tree_print( file_tree( MD_ROOT ) , $current_article );
    include_once 'view/index.php';
}

