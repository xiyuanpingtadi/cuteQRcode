<?php
include 'phpqrcode/phpqrcode.php';
$qrConf = array(
    'data' => 'http://www.baidu.com',
    'level' => 'H',
    'size' => 15,
    'mode' => 'background',
    'other' => array('filePath' => 'example\gif.gif',
        'emoji' => '😊',
    ),
);
if (is_file($qrConf['other']['filePath']) === false) {
    echo '文件不存在！';
    exit;
}
$isPic = exif_imagetype($qrConf['other']['filePath']);
if ($isPic === false) {
    echo '图片格式有误';
    exit;
}
$fileInfo = pathinfo($qrConf['other']['filePath']);
if ($qrConf['other']['filePath'] != '') {
    $outFile = dirname(__FILE__) . DIRECTORY_SEPARATOR .'temp' . DIRECTORY_SEPARATOR . md5($fileInfo['filename'] . time()) . '.' . $fileInfo['extension'];
}

$qrHander = \QRcode::png($qrConf['data'], $outFile, 'H', $qrConf['size'], 0, $saveandprint = false, $qrConf['mode'], $qrConf['other']);

// echo $qrHander;
header("Content-type: image/gif");
imagepng($qrHander);
