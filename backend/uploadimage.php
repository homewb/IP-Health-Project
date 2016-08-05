

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
/******************************************************************************

参数说明:
$max_file_size  : 上传文件大小限制, 单位BYTE
$destination_folder : 上传文件路径
$watermark   : 是否附加水印(1为加水印,其他为不加水印);

使用说明:
1. 将PHP.INI文件里面的"extension=php_gd2.dll"一行前面的;号去掉,因为我们要用到GD库;
2. 将extension_dir =改为你的php_gd2.dll所在目录;
******************************************************************************/

//上传文件类型列表
$uptypes=array(
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);

$max_file_size=2000000;     //upload Limit, unit BYTE
$destination_folder="./userPhotos/"; //upload path
$watermark=0;      //add watermark?(1 is add watermark on,other number is not);
$watertype=1;      //watermark type (1 is text,2 is picture)
$waterposition=1;     //the watermark's location (1 is Left-bottom, 2 is Riht-Bottom,3 is Left-top,4 is Right-top, 5 is center);
$waterstring="IPhealth";  //watermark text
$waterimg="xplore.gif";    //watermark picture
$imgpreview=0;      //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize=1/2;    //缩略图比例
?>
<html>
<head>
<title>Picture Upload</title>
<style type="text/css">
<!--
body
{
     font-size: 9pt;
}
input
{
     background-color: #66CCFF;
     border: 1px inset #CCCCCC;
}
-->
</style>
</head>

<body>
<form enctype="multipart/form-data" method="post" name="upform">
  Upload File:
  <input name="upfile" type="file">
  <input type="submit" value="上传"><br>
  The upload file types are allowed:<?=implode(', ',$uptypes)?>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!is_uploaded_file($_FILES["upfile"][tmp_name]))
    //check the file is exist
    {
         echo "The Picture is Not Exist!";
         exit;
    }

    $file = $_FILES["upfile"];
    if($max_file_size < $file["size"])
    //check file size
    {
        echo "File is Over-Size!";
        exit;
    }

    if(!in_array($file["type"], $uptypes))
    //check file type
    {
        echo "the file type is not match".$file["type"];
        exit;
    }

    if(!file_exists($destination_folder))
    {
        
    }

    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];

    //$destination = $destination_folder.time().".".$ftype;

    if (file_exists($destination) && $overwrite != true)
    {
        echo "同名文件已经存在了";
        exit;
    }

    if(!move_uploaded_file ($filename, $destination))
    {
        echo "移动文件出错";
        exit;
    }

    $pinfo=pathinfo($destination);
    $fname=$pinfo[basename];
    echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
    echo " 宽度:".$image_size[0];
    echo " 长度:".$image_size[1];
    echo "<br> 大小:".$file["size"]." bytes";

    // if($watermark==1)
    // {
    //     $iinfo=getimagesize($destination,$iinfo);
    //     $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
    //     $white=imagecolorallocate($nimage,255,255,255);
    //     $black=imagecolorallocate($nimage,0,0,0);
    //     $red=imagecolorallocate($nimage,255,0,0);
    //     imagefill($nimage,0,0,$white);
    //     switch ($iinfo[2])
    //     {
    //         case 1:
    //         $simage =imagecreatefromgif($destination);
    //         break;
    //         case 2:
    //         $simage =imagecreatefromjpeg($destination);
    //         break;
    //         case 3:
    //         $simage =imagecreatefrompng($destination);
    //         break;
    //         case 6:
    //         $simage =imagecreatefromwbmp($destination);
    //         break;
    //         default:
    //         die("不支持的文件类型");
    //         exit;
    //     }

    //     imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
    //     imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

    //     switch($watertype)
    //     {
    //         case 1:   //加水印字符串
    //         imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
    //         break;
    //         case 2:   //加水印图片
    //         $simage1 =imagecreatefromgif("xplore.gif");
    //         imagecopy($nimage,$simage1,0,0,0,0,85,15);
    //         imagedestroy($simage1);
    //         break;
    //     }

    //     switch ($iinfo[2])
    //     {
    //         case 1:
    //         //imagegif($nimage, $destination);
    //         imagejpeg($nimage, $destination);
    //         break;
    //         case 2:
    //         imagejpeg($nimage, $destination);
    //         break;
    //         case 3:
    //         imagepng($nimage, $destination);
    //         break;
    //         case 6:
    //         imagewbmp($nimage, $destination);
    //         //imagejpeg($nimage, $destination);
    //         break;
    //     }

    //     //覆盖原上传文件
    //     imagedestroy($nimage);
    //     imagedestroy($simage);
    // }

    if($imgpreview==1)
    {
    echo "<br>图片预览:<br>";
    echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
    echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
    }
}
?>
</body>
</html>
