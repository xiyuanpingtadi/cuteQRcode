<?php
use \Qrcode\PHPQRcode\QRcode;

include 'const.php';
include 'config.php';
include 'auto_load.php';

if (is_file($config['other']['filePath']) === false) {
    echo '文件不存在！';
    exit;
}
$isPic = exif_imagetype($config['other']['filePath']);
if ($isPic === false) {
    echo '图片格式有误';
    exit;
}
$fileInfo = pathinfo($config['other']['filePath']);
if ($config['other']['filePath'] != '') {
    $outFile = dirname(__FILE__) . DIRECTORY_SEPARATOR .'temp' . DIRECTORY_SEPARATOR . md5($fileInfo['filename'] . time()) . '.' . $fileInfo['extension'];
}

$qrHander = QRcode::png($config['data'], $outFile, $config['level'], $config['size'], 0, $saveandprint = false, $config['mode'], $config['other'],$config['alpha']);

if ($qrHander) echo '成功!';
