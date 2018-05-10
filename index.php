<?php
use \Qrcode\PHPQRcode\QRcode;

include 'const.php';
include 'auto_load.php';

$qrConf = array(
    'data' => 'https://github.com/',
    'level' => 'L',    //支持二维码容错率，动图时建议提高容错率能提高识别率
    'size' => 10,
    'mode' => 'background',
    'other' => ['filePath' => 'example\example.jpg',
                'char' => '██'
            ],
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

$qrHander = QRcode::png($qrConf['data'], $outFile, $qrConf['level'], $qrConf['size'], 0, $saveandprint = false, $qrConf['mode'], $qrConf['other']);

// echo $qrHander;
if ($qrHander) echo '成功!';
