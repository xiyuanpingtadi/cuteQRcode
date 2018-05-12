<?php
namespace Qrcode\PHPQRcode;

class QRimage
{

    //基础的黑点像素（最小）
    const basePixel = 5;
    //生成基础二维码后变成用户要求大小的放大倍数
    private static $magSize;

    public static $existsImagick;

    private static $qrcodesW;
    private static $qrcodesH;

    private static $outputFile;
    private static $tempQRcode;

    private static function haveImagick()
    {
        if (extension_loaded('imagick') ||
            class_exists('Imagick') ||
            class_exists('ImagickDraw') ||
            class_exists('ImagickPixel') ||
            class_exists('ImagickPixelIterator')
        ) {
            self::$existsImagick = true;
            return true;
        } else {
            self::$existsImagick = false;
            return false;
        }
    }

    //----------------------------------------------------------------------
    public static function png($frame, $filename = false, $pixelPerPoint, $outerFrame = 5, $saveandprint = false, $mode, $other, $alpha)
    {
        self::$outputFile = $filename;
        $mode = strtolower($mode);
        switch ($mode) {
            case 'normal':
                $image = self::image($frame, $pixelPerPoint, $outerFrame);
                break;
            case 'background':
                $image = self::imageBackground($frame, $pixelPerPoint, $outerFrame, realpath($other['filePath']), $alpha);
                break;
            case 'char':
                $image = self::imageChar($frame, $other['char']);
                break;
            default:
                echo '选择模式';
                return;
        }

        if (is_string($image)) {
            echo $image;
            return;
        }

//        if ($saveandprint === true) {
//            ImagePng($image, $filename);
//            header("Content-type: image/png");
//            ImagePng($image);
//        } else {
            ImagePng($image, $filename);
            return $image;
//        }

        ImageDestroy($image);
    }

    //----------------------------------------------------------------------
    public static function jpg($frame, $filename = false, $pixelPerPoint = 8, $outerFrame = 4, $q = 85)
    {
        $image = self::image($frame, $pixelPerPoint, $outerFrame);

        ImageJpeg($image, $filename, $q);

        ImageDestroy($image);
    }

    private static function imageChar($frame, $char)
    {
        $h = count($frame);
        $w = strlen($frame[0]);
        ob_start();
        echo '<table cellpadding="-20px" style="border:-2px;">';
        for ($y = 0; $y < $h; $y++) {
            echo '<tr>';
            for ($x = 0; $x < $w; $x++) {
                echo '<td>';
                if ($frame[$y][$x] == '1') {
                    echo $char;
                } else {
                    echo '&nbsp;';
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    //用图片作为整张二维码的背景图
    //$pixelPerPoint 原图中每点
    private static function imageBackground($frame, $pixelPerPoint, $outerFrame = 4, $backGroundPath, $alpha)
    {
        $h = count($frame);
        $w = strlen($frame[0]);

        //生成基础二维码后变成用户要求大小的放大倍数，放大倍数计算
        self::$magSize = ($pixelPerPoint / self::basePixel);
        $imgW = $w * self::basePixel;
        $imgH = $h * self::basePixel;

        $base_image = ImageCreate($imgW, $imgH);

        $col[0] = ImageColorAllocatealpha($base_image, 255, 255, 255, 0);//白点
        $col[1] = ImageColorAllocatealpha($base_image, 0, 0, 0, 0);//黑点
        $defaultAlpha = ($alpha===1)?ImageColorAllocatealpha($base_image, 168,168,168, 100):ImageColorAllocatealpha($base_image, 0, 0, 0, 127);


        imagefill($base_image, 0, 0, $defaultAlpha);
        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                //黑点
                if ($frame[$y][$x] == '1') {
                    for ($i = 0; $i < 5; $i++) {
                        for ($j = 0; $j < 5; $j++) {
                            if ($i == 2 && $j == 2) {
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[1]);
                            } else if ($x < 7 && $y < 7) {
                                //左上角定位符
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[1]);
                            } else if ($x > ($w - 8) && $y < 7) {
                                //右上角定位符
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[1]);
                                // }else if($y==6){
                                //      //横向定位符
                                //      ImageSetPixel($base_image,$x*self::basePixel+$outerFrame+$i,$y*self::basePixel+$outerFrame+$j,$col[1]);
                                // }else if($x==6){
                                //     //纵向定位符
                                //     ImageSetPixel($base_image,$x*self::basePixel+$outerFrame+$i,$y*self::basePixel+$outerFrame+$j,$col[1]);
                            } else if ($x < 7 && $y > ($h - 8)) {
                                //左下定位符
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[1]);
                            } else if ($x > ($w - 10) && $y > ($h - 10) && $x < ($w - 4) && $y < ($h - 4)) {
                                //右下定位符
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[1]);
                            }

                        }
                    }
                }

                //白点
                if ($frame[$y][$x] == '0' && !($x < 7 && $y < 7) && !($x > ($w - 7) && $y < 7) && !($x < 7 && $y > ($h - 7)) && !($x > ($w - 9) && $y > ($h - 9) && $x < ($w - 4) && $y < ($h - 4))) {
                    for ($i = 0; $i < 5; $i++) {
                        for ($j = 0; $j < 5; $j++) {
                            if ($i == 2 && $j == 2) {
                                ImageSetPixel($base_image, $x * self::basePixel + $outerFrame + $i, $y * self::basePixel + $outerFrame + $j, $col[0]);
                                // }else if($y==6){
                                //      //横向定位符
                                //      ImageSetPixel($base_image,$x*self::basePixel+$outerFrame+$i,$y*self::basePixel+$outerFrame+$j,$col[0]);
                                // }else if($x==6){
                                //     //纵向定位符
                                //     ImageSetPixel($base_image,$x*self::basePixel+$outerFrame+$i,$y*self::basePixel+$outerFrame+$j,$col[0]);
                            }
                        }
                    }
                }
            }
        }

        $target_image = ImageCreate($imgW * self::$magSize, $imgH * self::$magSize);
        ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * self::$magSize + 2 * $outerFrame, $imgH * self::$magSize + 2 * $outerFrame, $imgW, $imgH);
        ImageDestroy($base_image);
        self::$tempQRcode = 'temp' . DIRECTORY_SEPARATOR.'tempQRcode'.DIRECTORY_SEPARATOR.basename(self::$outputFile);
        ImagePng($target_image, self::$tempQRcode);
        return self::imageMerage($target_image, $backGroundPath);
    }

    private static function createImage($image)
    {
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($image);
                break;
            case 'png':
                $img = imagecreatefrompng($image);
                break;
            case 'bmp':
                $img = imagecreatefrombmp($image);
                break;
            case 'gif':
                $imagick = self::haveImagick();
                if ($imagick) {
                    $img = new Imagick($image);
                    $img = $img->coalesceImages();
                } else {
                    $img = imagecreatefromgif($image);
                }

                break;
            default:
                return '暂不支持的图片格式';
        }
        return $img;
    }

    private static function imageMerage($targetQRcode, $backGroundPath)
    {
        self::$qrcodesW = imagesx($targetQRcode);
        self::$qrcodesH = imagesy($targetQRcode);
        $img = self::createImage($backGroundPath);
        $qrcode = $background = self::backgroundResized($img);

        if ($background instanceof Imagick) {
            $targetQRcode = new Imagick(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.self::$tempQRcode);
            $background = $background->coalesceImages();
            do {
                $background->compositeImage($targetQRcode,Imagick::COMPOSITE_DEFAULT,0,0);
            } while ($background->nextImage()); 
            do {
                $qrcode->compositeImage($background,Imagick::COMPOSITE_DEFAULT,0,0);
            } while ($background->nextImage());
            $background = $background->deconstructImages();             
            $background->writeImages(self::$outputFile, true);
        } else{
            imagecopyResized($background, $targetQRcode, 0, 0, 0, 0, imagesx($background), imagesy($background), self::$qrcodesW, self::$qrcodesH);
        }

        return $background;
    }

    private static function backgroundResized($img)
    {
        if ($img instanceof Imagick) {
            do {
                $img->resizeImage(self::$qrcodesH, self::$qrcodesW, Imagick::FILTER_BOX, 1);
            } while ($img->nextImage());
            $img = $img->deconstructImages();
            return $img;
        } else {
            $background = imagecreatetruecolor(self::$qrcodesW, self::$qrcodesH);
            ImageCopyResized($background, $img, 0, 0, 0, 0, self::$qrcodesW, self::$qrcodesH, imagesx($img), imagesy($img));
            ImageDestroy($img);
            return $background;
        }
    }

    private static function image($frame, $pixelPerPoint = 4, $outerFrame = 4)
    {
        $h = count($frame);
        $w = strlen($frame[0]);

        $imgW = $w + 2 * $outerFrame;
        $imgH = $h + 2 * $outerFrame;

        $base_image = ImageCreate($imgW, $imgH);

        $col[0] = ImageColorAllocatealpha($base_image, 255, 255, 255, 0);
        $col[1] = ImageColorAllocatealpha($base_image, 0, 0, 0, 0);

        imagefill($base_image, 0, 0, $col[0]);

        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                if ($frame[$y][$x] == '1') {
                    ImageSetPixel($base_image, $x + $outerFrame, $y + $outerFrame, $col[1]);
                }
            }
        }

        $target_image = ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
        ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
        ImageDestroy($base_image);

        return $target_image;
    }
}