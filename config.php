<?php
$config = array(
    'data'  => 'https://github.com/',
    'level' => 'L',    //支持二维码容错率，动图时建议提高容错率能提高识别率
    'size'  => 300,
    'mode'  => 'background',
    'alpha' =>  1,//背景填充颜色，1半透明；2全透明。半透明可以提高识别度，但是会使背景原图变灰
    'other' => ['filePath' => 'example\example2.gif',
                'char' => '██'
                ],
);