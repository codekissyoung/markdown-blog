<?php
/*
    自动加载 autoload_lib 下的第三方类库
    autoload_lib 就是根命名空间
*/
spl_autoload_register( function($class){
    $class = str_replace('\\','/',$class);
    include_once '../autoload_lib/'.$class.'.php';
} );
