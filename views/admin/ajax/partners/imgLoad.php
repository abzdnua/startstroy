<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/partners/';
$db = db::getInstance();
if(!empty($_POST)){
    if(!empty($_FILES)){
            $img = new Upload($_FILES['img']);

            if($img->image_src_x != 180 AND $img->image_src_y != 51)
            {
                echo "Error: Размер баннера должен быть 180*51";
                exit();
            }
            $uniq = uniqid();

            $img -> file_new_name_body = $uniq;
            $img -> jpeg_quality = 100;
            $img -> process($pathToSaveImg);
            echo $uniq.'.'.$img->image_src_type;
    }else{
        echo 'Ошибка, файл не загружен';
        exit();
    }

}else{
    echo 'Ошибка, файл не загружен';
    exit();
}