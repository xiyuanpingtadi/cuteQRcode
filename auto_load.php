<?php
spl_autoload_register(function($class){
    $prefix = 'Qrcode\\PHPQRcode\\';
    $base_dir = __DIR__.DIRECTORY_SEPARATOR.'phpqrcode'.DIRECTORY_SEPARATOR;
    $len = strlen($prefix);
    $class_name = substr($class,$len);
    $file = $base_dir.str_replace('\\',DIRECTORY_SEPARATOR,$class_name).'.php';
    if (file_exists($file)) {
        require $file;
    } else {
        echo '自动加载类异常,找不到类：'.$class_name;
    }
    
});