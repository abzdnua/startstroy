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
    $dateObject = $_POST['objects_date'];
    $user = $_SESSION['userID'];
    $show = ($_POST['show'] == 'on')?1:0;
    $date = date('Y-m-d H:i:s');
    if(!preg_match("/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/",$dateObject)){
        echo 'Неверная дата';
        exit();
    }

    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE objects SET
                name = '{$name}',
                objectDate = '{$dateObject}',
                userUpdate = {$user},
                  `show` = {$show},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
    //    echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO objects
                (name,objectDate,`show`,userCreate,dateCreate)
                VALUES
                ('{$name}','{$dateObject}',{$show},{$user},'{$date}')";
//       echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();


    }

    if(!empty($_FILES['objects_img']['name'])!=''){
        $img = new Upload($_FILES['objects_img']);
        $uniq_img = uniqid();
        $img -> file_new_name_body = $uniq_img;
        $img -> jpeg_quality = 100;
        if($img->image_src_x > 752 or $img->image_src_y > 438)
        {
            if($img->image_src_x>$img->image_src_y){
                $img->image_x = 752;
                $img->image_ratio_y = true;
            }else{
                $img->image_y = 438;
                $img->image_ratio_x = true;
            }
            $img->image_resize = true;
        }

        $img -> process($pathToSaveImg);
        $img_str =  $uniq_img.'.'.$img->image_src_type;

        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_ratio_x = true;
        $img -> image_y = 75;
        $img -> image_resize = true;
        $img -> image_ratio_crop = true;
        $img -> process($pathToSaveImg);
        $thumb_str = 'm_'.$uniq_img.'.'.$img->image_src_type;

        $sql = "UPDATE objects SET
                img = '{$img_str}',
                 thumb = '{$thumb_str}'
                 WHERE id = {$id}";
      //  echo "error: ".$sql;
        $db->query($sql);
    }

}
else
{
    echo 'Пустые параметры';
}