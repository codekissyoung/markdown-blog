<?php
error_reporting( E_ALL );
// header( "Access-Control-Allow-Origin: *" );
// header( "Access-Control-Allow-Methods: *" );

/******************************** config ***************************/
include_once '../config.php';

/******************************** libs   ***************************/
$parser  	  = new HyperDown\Parser();

/******************************** env   ***************************/
$host               = $_SERVER["HTTP_HOST"];
$protocol           = @$_SERVER['HTTPS'] == 'on' || @$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ?  'https://' : 'http://';
$path_info          = isset($_SERVER['PATH_INFO']) ? $_SERVER["PATH_INFO"] : '';
$last_path_info_str = array_reverse(explode("/",$path_info))[0];
$site_title         = !empty($last_path_info_str) ? $last_path_info_str." | ".BLOG_TITLE : BLOG_TITLE;
$file_path          = MD_ROOT."{$path_info}";


// 文章
if( is_file( $file_path.".md" ) )
	$html = $parser -> makeHtml( file_get_contents( $file_path.".md" ) );

// 目录
elseif( is_dir( $file_path ) )
{
    $html =  $file_path == MD_ROOT ? "<h1>最新文章</h1>" : "<h1>文章列表</h1>";

	$md_file_list = file_list( $file_path );

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
        $html .= "<div class=article-summary-list>";
		$html .= "<h2><a href='$protocol$host/$href'>$article_name</a> <span class=article-create-time> {$semantic_time}</span></h2>";

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

        $html .= "</div>";
	}
}

// 搜索全文
$search_key = isset($_GET['search_key']) ? $_GET['search_key'] : '';
if( $search_key )
{
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
            $value          = str_ireplace( 
                                            $search_key,
                                            '<span class=search_key>'.$search_key.'</span>', 
                                            preg_replace( '/(^[-# ]*|`)/i', '', htmlentities( $ret[1] ) )
                                        );
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
}


/*********************************** view ***************************************/
// 上传图片
$is_upload_img = isset( $_GET['upload_img']) ? $_GET['upload_img'] : '';
if( $is_upload_img )
{
    $html 	   = "<h1>博客图床</h1>";
    include_once "view/upload_img.php";
    exit();
}
if( isset( $_GET['ajax'] ) )
{
    include_once 'view/article.php';
}
else
{
    $category = file_tree_print( file_tree( MD_ROOT ) , $path_info );
    include_once 'view/index.php';
}

