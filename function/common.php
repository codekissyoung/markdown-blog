<?php
function semantic_time($time)
{
	$time = strtotime( $time );
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

    if(time() < strtotime('+1 year',$time))
    {
        if(date('n') < date('n', $time))
            return (date('n') + 12 - date('n', $time)).'个月前';
        else
            return (date('n') - date('n', $time)).'个月前';
    }
    return (date('Y') - date('Y',$time)).'年前';
}

function file_list( $path )
{
	$tree = scandir($path);

	$tree = array_diff( $tree, [".","..",".gitignore",".git",".svn",".vscode","README.md"] );

	$file_list = [];
	foreach($tree as $key => $leaf)
	{
		if( is_dir( $path."/".$leaf ) )
			$file_list = array_merge( $file_list, file_list($path.$leaf) );
		else
		{
			$file['path'] = $path."/".$leaf;
			$file['time'] = date( "Y-m-d H:i:s", filemtime( $file['path'] ) );
			$file_list[] = $file;
		}
	}
	return $file_list;
}

function sort_file_list( $file_list )
{
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


function debug($var)
{
	echo "<pre><code>";
	print_r($var);
	echo "</code></pre>";
	exit;
}
