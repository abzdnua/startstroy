<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/sc_img/banners/';

if(!empty($_POST)){
    if(!empty($_FILES)){
        switch($_POST['type'])
        {
            case 'night':
                $name = 'night';
                break;
            case 'weekend':
                $name = 'weekend';
                break;
            case 'default':
                $name = 'default';
                break;
        }
        $img = new Upload($_FILES['picture']);

        if($img->image_src_x != 392 AND $img->image_src_y != 71)
        {
            echo "Ошибка - Размер баннера должен быть 392*71";
            exit();
        }

        if(file_exists($pathToSaveImg.$name.'.png'))
        {
            @unlink($pathToSaveImg.$name.'.png');
        }

        $img -> file_new_name_body = $name;
        $img -> image_convert = 'png';
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        echo $name;

    }else{
        echo 'Ошибка, файл не загружен';
        exit();
    }

}else{
    echo 'Ошибка, файл не загружен';
    exit();
}

?>