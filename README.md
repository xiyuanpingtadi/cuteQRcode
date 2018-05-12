# cuteQRcode
一个胡里花哨没啥卵用的二维码
可以生成完整背景图片（包括GIF动图）的二维码，和纯字符形式（包括emoji表情）的二维码  
## 示例
![](https://raw.githubusercontent.com/xiyuanpingtadi/cuteQRcode/master/temp/f026baf9ac80b64cb223a8a56c61d738.gif)  
![](https://raw.githubusercontent.com/xiyuanpingtadi/cuteQRcode/master/temp/38c75f3c2621311e1f8a09a6c92a85f3.jpg)  
![](https://raw.githubusercontent.com/xiyuanpingtadi/cuteQRcode/master/temp/739315c390ce5dde2e211e5bd2c06380.jpg)  
## 使用  
配置文件`config.php`  
    
>`data`内容&emsp;&emsp;&emsp;&emsp;填写扫码后的连接或信息  
>`level`容错等级&emsp;&ensp;常规二维码容错等级  
>`size`尺寸&emsp;&emsp;&emsp;&emsp;大小单位像素，不超过1000px，不小于125px  
>`mode`模式&emsp;&emsp;&emsp;&emsp;background背景图模式，normal常规模式，char字符模式  
>`alpha`透明度&emsp;&emsp;&ensp;背景填充颜色，1半透明；2全透明。在背景图片非常暗的情况下半透明可以提高识别度，但是会使背景原图变灰  
>`other`其他内容  
>>`filePath`      背景图片路径  
>>`char`          字符模式使用的字符（可以使用emoji）
## TODO
- [ ] 加入页边距支持  
- [X] 容错率可以自由调整
- [X] 尺寸可调节
