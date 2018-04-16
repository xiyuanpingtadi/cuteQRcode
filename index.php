<?php
include 'phpqrcode/phpqrcode.php';
    $qrConf = array(
        'data'  	=> 'http://www.baidu.com',
        'level'     => 'H',
        'size'	    => 20,
        'mode'      => 'Background',
        'filePath'  => 'example/download.jpg'
    );
    
    // try{
    //     $img = imagecreatefromjpeg($qrConf['filePath']);
    // }catch  (Exception $e) {
    //     echo '图片生成错误：'.$e->getMessage();
    // }

    $qrHander = \QRcode::png($qrConf['data'], 'output.png', 'H', $qrConf['size'],0,$saveandprint=false,$qrConf['mode'],$qrConf['filePath']);

    // $qrcodesx = imagesx($qrHander);
    // $qrcodesy = imagesy($qrHander);
    // $background =imagecreatetruecolor($qrcodesx,$qrcodesy);
    // ImageCopyResized($background, $img, 0, 0, 0, 0,$qrcodesx,$qrcodesy,imagesx($img), imagesy($img));
    // ImageDestroy($img);

    // try{
    //     ImageCopyResized($background, $qrHander, 0, 0, 0, 0,imagesx($background),imagesy($background),$qrcodesx,$qrcodesy);
    // }catch (Exception $e){
    //     echo '图片合并错误：'.$e->getMessage();
    // }
    // ImageDestroy($qrHander);
    header("Content-type: image/jpeg");
    imagepng($qrHander);
    // echo $qrcodesx.PHP_EOL.$qrcodesy;
    // echo imagesx($background).PHP_EOL.imagesy($background);
