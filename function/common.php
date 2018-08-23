<?php
// $path 路径 返回目录树数组
function file_tree($path)
{
	$tree = scandir($path);
	sort($tree, SORT_STRING ); // 按照数值大小排序数组，主要考虑到看书的笔记，目录方便记录
	foreach($tree as $key => $leaf){
		if($leaf == "." || $leaf == ".."){
			unset($tree[$key]);
		}elseif(is_dir($path.'/'.$leaf)){
			unset($tree[$key]);
			$tree[$leaf] = file_tree($path.'/'.$leaf);
		}
	}
	return $tree;
}

// $tree 是目录数组
// $path 是目录
// $cf 是当前文章
function file_tree_print($tree,$cf = '',$path = false)
{
    global $IGNORE_DIR;
    global $IGNORE_FILE;
    if($path)
    {
		if(strpos($cf,$path) === false){
			$html = "<ul class=hide>";
		}else{
			$html = "<ul>";
		}
    }
    else
    {
		$html = "<ul>";
	}

	foreach($tree as $key => $leaf)
	{
        if( $path )
        {
            $dir = "$path/$key";
        }
        else
        {
            $dir = "/$key";
        }

        if(in_array( substr($dir, 1), $IGNORE_DIR )) continue;

		if(is_array($leaf))
		{
			$html .= "<li><h2>$key<span class=caret></span></h2>".file_tree_print($leaf,$cf,"{$path}/{$key}")."</li>";
		}
		else
		{
			if(!preg_match("/md$/",$leaf)) continue;

			$leaf = substr($leaf,0,-3);

            if( $path )
            {
				$href = "$path/$leaf";
            }
            else
            {
				$href = "/$leaf";
			}

            if( in_array( substr($href,1), $IGNORE_FILE ) ) continue;

            if($cf == $href)
            {
				$html .= "<li><a href='$href' class=active>$leaf</a></li>";
            }
            else
            {
				$html .= "<li><a href='$href'>$leaf</a></li>";
			}
		}
	}
	$html .= "</ul>";
	return $html;
}


function debug($var)
{
	echo "<pre><code>";
	print_r($var);
	echo "</code></pre>";
	exit;
}
