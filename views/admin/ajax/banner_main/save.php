<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/banner/';
$db = db::getInstance();
if(!empty($_POST)){
    $str1 = $_POST['str1'];
    $str2 = $_POST['str2'];
    $str3 = $_POST['str3'];
    $show = ($_POST['show'] == 'on')?1:0;
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');

    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE banners SET
                firstStr = '{$str1}',
                secondStr = '{$str2}',
                thirdStr = '{$str3}',
                userUpdate = {$user},
                `show` = '{$show}',
                dateUpdate = '{$date}'

                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO banners
                (firstStr,secondStr,thirdStr,`show`,userCreate,dateCreate)
                VALUES
                ('{$str1}','{$str2}','{$str3}','{$show}',{$user},'{$date}')";
     //   echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();


    }

    if(!empty($_FILES['banner_img']['name'])!=''){
        $img = new Upload($_FILES['banner_img']);

        if($img->image_src_x != 1024 AND $img->image_src_y != 360)
        {
            $db->query("DELETE FROM banners WHERE id = {$id}");
            echo "error: Размер баннера должен быть 1024*360";
            exit();
        }
        $uniq_img = uniqid();

        $img -> file_new_name_body = $uniq_img;
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        $img_str =  $uniq_img.'.'.$img->image_src_type;

       /* $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 311;
        $img -> image_y = 175;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str = 'm_'.$uniq_img.'.'.$img->image_src_type;*/

        $sql = "UPDATE banners SET
                img = '{$img_str}'
                WHERE id = {$id}";
       // echo "error: ".$sql;
        $db->query($sql);
    }


}
else
{
    echo 'error: Пустые параметры';
}