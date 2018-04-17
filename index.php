<?php
include 'phpqrcode/phpqrcode.php';
    $qrConf = array(
        'data'  	=> 'https://www.baidu.com',
        'level'     => 'H',
        'size'	    => 15,
        'mode'      => 'emoji',
        'other'     => array('filePath' => '', 
                             'emoji'    => '😋'
                        )
    );  
    $qrHander = \QRcode::png($qrConf['data'], 'output.png', 'H', $qrConf['size'],0,$saveandprint=false,$qrConf['mode'],$qrConf['other']);
    header("Content-type: image/jpeg");
    imagepng($qrHander);
