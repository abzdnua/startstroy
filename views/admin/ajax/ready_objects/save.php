<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/objects/';
$db = db::getInstance();
if(!empty($_POST)){
    $name = $_POST['objects_name'];
    $date = $_POST['objects_date'];
     $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');

    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE objects SET
                name = '{$name}',
                objectDate = '{$date}',
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO objects
                (name,objectDate,userCreate,dateCreate)
                VALUES
                ('{$name}','{$date}',{$user},'{$date}')";
       echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();


    }

    if(!empty($_FILES['objects_img']['name'])!=''){
        $img = new Upload($_FILES['article_img']);

        if($img->image_src_x > 752 AND $img->image_src_y > 438)
        {
            echo "error: Размер картинки должен быть  не более 752*438";
            exit();
        }
        $uniq_img = uniqid();

        $img -> file_new_name_body = $uniq_img;
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        $img_str =  $uniq_img.'.'.$img->image_src_type;

        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 110;
        $img -> image_y = 75;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str = 'm_'.$uniq_img.'.'.$img->image_src_type;

        $sql = "UPDATE objects SET
                img = '{$img_str}',
                 WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
    }

}
else
{
    echo 'error: Пустые параметры';
}