<?php
function debug($var)
{
    if( is_string($var) )
        $log = $var;
    else
        // 格式化打印 + 不转义中文 与 斜杠
        $log = json_encode( $var, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

    $log .= "\n";

    file_put_contents( "debug.log",  $log, FILE_APPEND );
}

function semantic_time($time_str)
{
	$time = strtotime( $time_str );
    $today_zero_time = strtotime(date("Y-m-d"),time());
    $tomorrow_zero_time = $today_zero_time + 24 * 60 * 60;

    // 今天内的时间
    if( $tomorrow_zero_time - $time < 24 * 60 * 60 )
    {
        $diff_time = time() - $time;
        if($diff_time < 60)
            return '刚刚';
        if($diff_time < 3600)
            return floor($diff_time / 60) . '分钟前';
        if($diff_time < 24 * 60 * 60)
            return floor($diff_time / 3600) . '小时前';
    }

    $diff_time = $today_zero_time - $time;
    if( $diff_time < 60 * 60 * 6 )
        return '昨晚';
    if( $diff_time < 24 * 60 * 60 )
        return '昨天';
    if( $diff_time < 24 * 60 * 60 * 2 )
        return '前天';

    $count = $tomorrow_zero_time - $time;
    if($count < 24 * 60 * 60 * 7)
        return floor($count/(24 * 60 * 60) ).'天前';

    if(time() < strtotime('+1 month',$time))
        return floor($count/(24*60*60*7)).'周前';

    return date("Y年n月t日",$time);
}

function file_list( $path )
{
    $path = preg_replace('/\/$/im','',$path);
	$tree = scandir( $path );
	$tree = array_diff( $tree, [".","..",".gitignore",".git",".svn",".vscode","README.md"] );

	$file_list = [];
	foreach($tree as $key => $leaf)
	{
	    $leaf_path = "{$path}/{$leaf}";
		if( is_dir( $leaf_path ) )
        {
			$file_list = array_merge( $file_list, file_list( $leaf_path ) );
        }
		else
		{
			$file['path'] = $leaf_path;
			$file['time'] = date( "Y-m-d H:i:s", filemtime( $file['path'] ) );
			$file_list[] = $file;
		}
	}

    foreach( $file_list as $k => $v )
    {
        $time[$k] = $v['time'];
    }

    array_multisort( $time, SORT_DESC, SORT_STRING, $file_list );
    return $file_list;
}

// $path 路径 返回目录树数组
function file_tree($path)
{
	$tree = scandir($path);
	sort($tree, SORT_STRING ); // 按照数值大小排序数组，主要考虑到看书的笔记，目录方便记录
	foreach($tree as $key => $leaf)
	{
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


