<?php
session_start();
$root = $_SERVER[DOCUMENT_ROOT];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/partners/';
$db = db::getInstance();
if(!empty($_POST)){
    $name = $_POST['partner_name'];
    $des = $_POST['partner_des'];
   // $img = $_POST['partner_img'];
    $link = (substr($_POST['partner_link'],7))?$_POST['partner_link']:"";
    $user = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');
    $show = ($_POST['show']=='on')?1:0;

    if($_POST['id']!=''){
        $id = $_POST['id'];
        $sql = "UPDATE partners SET
                name = '{$name}',
                des = '{$des}',
                `show` = {$show},
                link = '{$link}',
                userUpdate = {$user},
                dateUpdate = '{$date}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);

    }else{
        $sql = "INSERT INTO partners
                (name,des,`show`,link,userCreate,dateCreate)
                VALUES
                ('{$name}','{$des}',{$show},'{$link}',{$user},'{$date}')";
//        echo "error: ".$sql;
        $db->query($sql);
        $id = $db->last();


    }

    if(!empty($_FILES['partner_img']['name'])!=''){
        $img = new Upload($_FILES['partner_img']);

        if($img->image_src_x != 180 AND $img->image_src_y != 51)
        {
            echo "error: Размер баннера должен быть 180*51";
            exit();
        }
        $uniq = uniqid();

        $img -> file_new_name_body = $uniq;
        $img -> jpeg_quality = 100;
        $img -> process($pathToSaveImg);
        $img =  $uniq.'.'.$img->image_src_type;

        $sql = "UPDATE partners SET
                img = '{$img}'
                WHERE id = {$id}";
//        echo "error: ".$sql;
        $db->query($sql);
    }
}
else
{
    echo 'error: Пустые параметры';
}