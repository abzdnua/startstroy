<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/articles/';
$db = db::getInstance();
if(!empty($_POST)){
    $name = $_POST['article_name'];
    $des = $_POST['article_shortdes'];
   // $img = $_POST['partner_img'];
    $text = $_POST['article_text'];

    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');
    $show = ($_POST['show']=='on')?1:0;
    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE articles SET
                name = '{$name}',
                shortDes = '{$des}',
                text = '{$text}',
                `show`={$show},
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO articles
                (name,shortDes,text,`show`,userCreate,dateCreate)
                VALUES
                ('{$name}','{$des}','{$text}',{$show},{$user},'{$date}')";
//        echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();


    }

    if(!empty($_FILES['article_img']['name'])!=''){
        $img = new Upload($_FILES['article_img']);
//echo $img->image_src_x.'  '.$img->image_src_y;
        if($img->image_src_x != 640 or $img->image_src_y != 360)
        {


            $db->query("DELETE FROM articles WHERE id = {$id}");
            echo "Размер изображения должен быть 640px*360px";
            exit();
        }
        $uniq_img = uniqid();

        $img -> file_new_name_body = $uniq_img;
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        $img_str =  $uniq_img.'.'.$img->image_src_type;

        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 311;
        $img -> image_y = 175;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str = 'm_'.$uniq_img.'.'.$img->image_src_type;

        $sql = "UPDATE articles SET
                img = '{$img_str}',
                thumb = '{$thumb_str}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
    }

    if(!empty($_FILES['article_thumb']['name'])!=''){
        $thumb = new Upload($_FILES['article_thumb']);

        if($thumb->image_src_x < 311 or $thumb->image_src_y < 175)
        {
            echo "Размер превью должен быть не менее 311*175";
            exit();
        }
        $uniq = uniqid();
        $thumb -> image_x = 311;
        $thumb -> image_y = 175;
        $thumb -> image_resize = true;
        $thumb -> image_ratio_crop = true;
        $thumb -> file_new_name_body = $uniq;
        $thumb -> jpeg_quality = 100;
        $thumb -> process($pathToSaveImg);
        $thumb =  $uniq.'.'.$thumb->image_src_type;

        @unlink($pathToSaveImg.'/'.$thumb_str);

        $sql = "UPDATE articles SET
                thumb = '{$thumb}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
    }
}
else
{
    echo 'error: Пустые параметры';
}