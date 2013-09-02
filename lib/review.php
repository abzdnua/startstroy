<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/lib/class.invis.db.php';
require_once $root.'/lib/class.dll.php';
require_once $root.'/lib/class.upload.php';
$pathToSaveImg = $root.'/img/client/';
$db = db::getInstance();

if($_POST)
{


    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    $review = $_POST['review'];
   /* if($name == '')
    {
        echo json_encode(array('err'=>'Введите имя'));
        exit;
    }

    if($phone == '')
    {
        echo json_encode(array('err'=>'Введите телефон'));
        exit;
    }

    if($review == '')
    {
        echo json_encode(array('err'=>'Оставьте ваш отзыв'));
        exit;
    }*/
    $sql = "INSERT INTO clients(name,phone) VALUES ('".$name."','".$phone."')";
    $db->query($sql);
    $id=$db->last();

    $sql = "INSERT INTO reviews(client_id,text,dateCreate,`show`) VALUES ({$id},'{$review}',NOW(),0)";
    $db->query($sql);


    echo json_encode(array('mess'=>'ok'));

    if(!empty($_FILES['upload']['name'])!=''){
        echo json_encode(array('err'=>'Заполните поля'));
        $img = new Upload($_FILES['upload']);

        if($img->image_src_x < 80 AND $img->image_src_y < 80)
        {
            echo "error: Размер фото должен быть не менее 80*80";
            exit();
        }
        $uniq_img = uniqid();


        $img -> file_new_name_body = 'm_'.$uniq_img;
        $img -> jpeg_quality = 100;
        $img -> image_x = 80;
        $img -> image_y = 80;
        $img ->image_resize = true;
        $img -> process($pathToSaveImg);
        $thumb_str =$uniq_img.'.'.$img->image_src_type;


        $sql = "UPDATE clients SET img = '{$thumb_str}' WHERE id = {$id}";

       echo "error: ".$sql;
        $db->query($sql);
    }
    else
    {
        echo "error: ".$sql;
    }

}
else
{
    echo json_encode(array('err'=>'Заполните поля'));
}
