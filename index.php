<?php
require 'vendor/autoload.php';
require 'phpqrcode/phpqrcode.php';
    $qrConf = array(
        'data'  	=> 'https://github.com/',
        'level'     => 'H',
        'size'	    => 15,
        'mode'      => 'background',
        'other'     => array('filePath' => 'example/example_gif.gif', 
                             'string'    => '🌆' //like ▇▇▇ or 🌆
                        )
    );  
    $qrHander = \QRcode::png($qrConf['data'], false, 'H', $qrConf['size'],0,$saveandprint=false,$qrConf['mode'],$qrConf['other']);

    // echo $qrHander;
    header("Content-type: image/gif");
    $qrHander->blob('gif'); 
    // imagepng($qrHander);
