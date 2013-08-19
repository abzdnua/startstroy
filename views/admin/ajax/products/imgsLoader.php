<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/sc_img/product/';

if($_FILES['photo_gallery'])
{
    set_time_limit(0);
    $files = array();
    foreach ($_FILES['photo_gallery'] as $k => $l)
    {
        foreach ($l as $i => $v)
        {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }

    $errors = array();
    $photos = array();
    foreach ($files as $file){
        $uniq = uniqid();
        $foo = new upload($file);
        if ($foo -> uploaded)
        {
            $w = $foo -> image_src_x;
            $h = $foo -> image_src_y;
            if($h < 426)
            {
                array_push($errors,array('filename' => $file['name'], 'err' => 'высота картинки должна быть больше 426px'));
            }
            else
            {
                if($w < 450)
                {
                    array_push($errors,array('filename' => $file['name'], 'err' => 'ширина картинки должна быть больше 450px'));
                }
                else
                {
                    $foo -> file_new_name_body = $uniq;
                    $foo -> image_convert = 'jpg';
                    $foo -> image_resize = true;
                    $foo -> image_y      = 426;
                    $foo -> image_ratio_x = true;
                    $foo -> process($pathToSaveImg);
                    array_push($photos,$uniq.'.jpg');
                }
            }
        }
    }

    foreach($photos as $photo){
        echo '<div class="float_left"><img style="margin:15px;" src="../sc_img/product/'.$photo.'" height="60" class="sm_img"/><img class="del_gal_photo" src="../sc_img/admin/b_drop.png" /></div>';
    }

    if(!empty($errors))
    {
        echo '<div class="clear"></div><div id="for_mistakes">';
        foreach($errors as $key => $value){
            echo '<span style="color:red; font: 14px Verdana">Ошибка загрузки файла  '.$value['filename'].' - '.$value['err'].'</span><br />';
        }
        echo '</div>';
    }
}
else
{
    echo 'error Файлы не были загружены';
}