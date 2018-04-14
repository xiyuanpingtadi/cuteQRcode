<?php
include 'phpqrcode/phpqrcode.php';
    $bgFile = 'example/example.jpg';
    $qrConf = array(
        'data'	=> 'http://www.baidu.com',
        'level' => 'H',
        'size'	=> 20,
        'margin'=> 1
    );
    try{
        $img = imagecreatefromjpeg($bgFile);
    }catch  (Exception $e) {
        echo '图片生成错误：'.$e->getMessage();
    }
    $qrHander = \QRcode::png($qrConf['data'], 'output.png', 'H', $qrConf['size'], $qrConf['margin']);
    try{
        imagecopyResized($img, $qrHander, 0, 0, 0, 0, imagesx($img), imagesy($img),imagesx($qrHander), imagesy($qrHander));
    }catch (Exception $e){
        echo '图片合并错误：'.$e->getMessage();
    }
    header("Content-type: image/jpeg");
    imagepng($img);
